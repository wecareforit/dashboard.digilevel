<?php

namespace App\Filament\Resources;

use App\Enums\Priority;
use App\Enums\TaskTypes;
use App\Filament\Resources\TaskResource\Pages;
use App\Models\RelationLocation;
use App\Models\Task;
use App\Models\User;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Forms\Components\{DatePicker, Section, Select, Textarea, TimePicker, ToggleButtons};
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\{DeleteAction, EditAction, RestoreAction, Action, ActionGroup, BulkActionGroup};
use Filament\Tables\Columns\{ImageColumn, TextColumn};
use Filament\Tables\Filters\{SelectFilter, TrashedFilter};
use Filament\Tables\Enums\FiltersLayout;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use Relaticle\CustomFields\Filament\Forms\Components\CustomFieldsComponent;

class TaskResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = Task::class;
    protected static ?string $navigationIcon = 'heroicon-o-list-bullet';
    protected static ?string $navigationLabel = 'Mijn taken';
    protected static ?string $pluralModelLabel = 'Mijn taken';
    protected static ?string $title = 'Mijn taken';

    protected $listeners = ['refresh' => '$refresh'];

    public static function getPermissionPrefixes(): array
    {
        return [
            'view', 'view_any', 'create', 'update', 'delete', 'delete_any',
            'assign_to_employee', 'edit_any', 'compleet_any',
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return (string) Task::where('employee_id', auth()->id())->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        $count = Task::where('employee_id', auth()->id())->count();

        if ($count === 0) return null;
        if ($count < 5) return 'success';
        if ($count < 10) return 'warning';
        return 'danger';
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Textarea::make('description')
                ->rows(3)
                ->label('Uitgebreide omschrijving')
                ->helperText(str('Beschrijf de actie of taak')->inlineMarkdown()->toHtmlString())
                ->columnSpanFull()
                ->autosize(),

            Select::make('relation_id')
                ->searchable()
                ->label('Relatie')
                ->options(fn() => \App\Models\Relation::all()
                    ->groupBy('type.name')
                    ->mapWithKeys(fn($group, $category) => [
                        $category => $group->pluck('name', 'id')->toArray(),
                    ])
                    ->toArray()
                )
                ->afterStateUpdated(fn(callable $set) => [
                    $set('location_id', null),
                    $set('contact_id', null),
                ])
                ->reactive(),

            Select::make('location_id')
                ->label('Locatie')
                ->options(fn(callable $get) => RelationLocation::query()
                    ->when($get('relation_id'), fn($q) => $q->where('relation_id', $get('relation_id')))
                    ->get()
                    ->mapWithKeys(fn($location) => [
                        $location->id => collect([$location->address, $location->zipcode, $location->place])
                            ->filter()
                            ->implode(', '),
                    ])
                    ->toArray()
                )
                ->reactive()
                ->disabled(fn(callable $get) => !$get('relation_id'))
                ->visible(setting('tasks_in_location') ?? false)
                ->placeholder('Selecteer een locatie'),

            Select::make('employee_id')
                ->options(User::pluck('name', 'id'))
                ->default(Auth::id())
                ->visible(fn() => auth()->user()->can('assign_to_employee_task'))
                ->label('Interne medewerker'),

            Select::make('type')
                ->options(TaskTypes::class)
                ->default(TaskTypes::TODO)
                ->required()
                ->searchable()
                ->label('Type'),

            ToggleButtons::make('priority')
                ->options(Priority::class)
                ->default(Priority::LOW->value)
                ->grouped()
                ->label('Prioriteit'),

            CustomFieldsComponent::make()->columnSpanFull(),

            Section::make('Planning')
                ->columns(3)
                ->schema([
                    DatePicker::make('begin_date')->label('Begindatum'),
                    TimePicker::make('begin_time')->label('Tijd')->seconds(false),
                    DatePicker::make('deadline')->label('Einddatum'),
                ]),
        ]);
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()->where('employee_id', auth()->id());
    }

    public static function table(Table $table): Table
    {
        $today = Carbon::today();
        $tomorrow = Carbon::tomorrow();
        $nextWeekStart = Carbon::now()->addWeek()->startOfWeek();
        $nextWeekEnd = Carbon::now()->addWeek()->endOfWeek();

        return $table
            ->defaultSort('id', 'desc')
            ->persistSortInSession()
            ->persistSearchInSession()
            ->searchable()
            ->persistColumnSearchesInSession()
            ->columns([
                ImageColumn::make('make_by_employee.avatar')
                    ->size(30)
                    ->square()
                    ->circular()
                    ->stacked()
                    ->label('')
                    ->tooltip(fn($record) =>
                        $record->make_by_employee_id === $record->employee_id
                            ? 'Gemaakt door: ' . $record->make_by_employee?->name . ' (ook eigenaar)'
                            : implode(', ', array_filter([
                                'Medewerker: ' . $record->employee?->name,
                                'Gemaakt door: ' . $record->make_by_employee?->name,
                            ]))
                    )
                    ->getStateUsing(fn($record) =>
                        $record->make_by_employee_id === $record->employee_id
                            ? [$record->make_by_employee?->avatar]
                            : [$record->make_by_employee?->avatar, $record->employee?->avatar]
                    ),

                TextColumn::make('type')
                    ->badge()
                    ->sortable()
                    ->toggleable()
                    ->width('100px')
                    ->label('Type'),

                TextColumn::make('priority')
                    ->badge()
                    ->sortable()
                    ->width('150px')
                    ->toggleable()
                    ->label('Prioriteit'),

                TextColumn::make('related_to')
                    ->label('Relatie')
                    ->wrap(0)
                    ->toggleable()
                    ->getStateUsing(fn($record): ?string => $record?->related_to?->name)
                    ->placeholder('-'),

                TextColumn::make('description')
                    ->label('Taak')
                    ->grow()
                    ->placeholder('-')
                    ->toggleable()
                    ->description(fn($record) => $record?->make_by_employee_id === auth()->id()
                        ? ($record?->created_at?->translatedFormat('d F Y \o\m H:i') ?? '-')
                        : sprintf(
                            'Door: %s op %s om %s',
                            $record?->make_by_employee?->name ?? 'Onbekend',
                            $record?->created_at?->translatedFormat('d F Y') ?? '-',
                            $record?->created_at?->translatedFormat('H:i') ?? '-'
                        )
                    ),

                TextColumn::make('begin_date')
                    ->label('Plandatum')
                    ->sortable()
                    ->dateTime('d-m-Y')
                    ->toggleable()
                    ->placeholder('-'),

                TextColumn::make('deadline')
                    ->label('Einddatum')
                    ->sortable()
                    ->dateTime('d-m-Y')
                    ->toggleable()
                    ->placeholder('-'),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->getStateUsing(fn($record) => match (true) {
                        !$record->begin_date && !$record->deadline => 'Onbekend',
                        $record->deadline && strtotime($record->deadline) < now()->startOfDay()->timestamp => 'Verlopen',
                        $record->begin_date && strtotime($record->begin_date) > now()->endOfDay()->timestamp => 'Nog niet gestart',
                        $record->begin_date && strtotime($record->begin_date) <= now()->endOfDay()->timestamp
                            && (!$record->deadline || strtotime($record->deadline) >= now()->startOfDay()->timestamp) => 'Gestart',
                        default => '-',
                    })
                    ->color(fn($state) => match ($state) {
                        'Onbekend' => 'primary',
                        'Verlopen' => 'danger',
                        'Nog niet gestart' => 'warning',
                        'Gestart' => 'success',
                        default => 'gray',
                    }),
            ])
            ->filters([
                SelectFilter::make('relation_id')
                    ->label('Relatie')
                    ->searchable()
                    ->options(fn() => \App\Models\Relation::all()
                        ->groupBy('type.name')
                        ->mapWithKeys(fn($group, $category) => [
                            $category => $group->pluck('name', 'id')->toArray(),
                        ])
                        ->toArray()
                    ),

                SelectFilter::make('status_filter')
                    ->label('Status')
                    ->options([
                        'onbekend'         => 'Onbekend',
                        'verlopen'         => 'Verlopen',
                        'nog_niet_gestart' => 'Nog niet gestart',
                        'gestart'          => 'Gestart',
                    ])
                    ->query(function (\Illuminate\Database\Eloquent\Builder $query, array $data) {
                        $value = $data['status_filter'] ?? null;
                        if (! $value) return;

                        switch ($value) {
                            case 'onbekend':
                                $query->whereNull('begin_date')->whereNull('deadline');
                                break;
                            case 'verlopen':
                                $query->whereNotNull('deadline')->where('deadline', '<', now()->startOfDay());
                                break;
                            case 'nog_niet_gestart':
                                $query->whereNotNull('begin_date')->where('begin_date', '>', now()->endOfDay());
                                break;
                            case 'gestart':
                                $query->whereNotNull('begin_date')
                                    ->where('begin_date', '<=', now()->endOfDay())
                                    ->where(fn($sub) => $sub->whereNull('deadline')->orWhere('deadline', '>=', now()->startOfDay()));
                                break;
                        }
                    }),

                SelectFilter::make('delete')
                    ->label('Status')
                    ->options([
                        'open'   => 'Open taken',
                        'closed' => 'Voltooide taken',
                        'all'    => 'Alle taken',
                    ])
                    ->query(function (\Illuminate\Database\Eloquent\Builder $query, array $data) {
                        $values = $data['values'] ?? [];
                        if (in_array('open', $values)) $query->orWhereNull('deleted_at');
                        if (in_array('closed', $values)) $query->orWhereNotNull('deleted_at');
                        if (in_array('all', $values)) $query->withTrashed();
                    }),
            ], layout: FiltersLayout::Modal)
            ->filtersFormColumns(2)
            ->actions([
                EditAction::make()
                    ->modalHeading('Taak Bewerken')
                    ->modalDescription('Pas de bestaande taak aan door de onderstaande gegevens zo volledig mogelijk in te vullen.')
                    ->tooltip('Bewerken')
                    ->slideOver()
                    ->visible(fn() => auth()->user()->can('edit_any_task'))
                    ->label('Bewerken'),

                Action::make('complete')
                    ->label('Voltooien')
                    ->icon('heroicon-o-check')
                    ->tooltip('Voltooien')
                    ->color('danger')
                    ->modalHeading('Actie voltooien')
                    ->modalDescription('Weet je zeker dat je deze actie wilt voltooien?')
                    ->modalIcon('heroicon-o-check')
                    ->requiresConfirmation()
                    ->visible(fn($record) => auth()->user()->can('compleet_any_task') || $record->employee_id === auth()->id())
                    ->action(fn($record) => $record->update(['deleted_at' => Carbon::now()])),

                ActionGroup::make([
                    DeleteAction::make()->tooltip('Verwijderen')->label('Verwijderen'),
                    RestoreAction::make()
                        ->color('danger')
                        ->modalHeading('Actie terug plaatsen')
                        ->modalDescription('Weet je zeker dat je deze actie wilt activeren'),
                ])->visible(fn($record) => auth()->user()->can('delete_any_task') || $record->employee_id === auth()->id()),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    ExportBulkAction::make()->exports([
                        ExcelExport::make()
                            ->fromTable()
                            ->withWriterType(\Maatwebsite\Excel\Excel::XLSX)
                            ->withFilename(now()->format('d-m-Y H:i') . ' - Takenoverzicht export'),
                    ]),
                ]),
            ])
            ->emptyState(view('components.empty-state', [
                'title' => 'Geen taken',
                'description' => 'Maak een nieuwe actie aan door op de knop hieronder te klikken.',
                'action' => new \Illuminate\Support\HtmlString(
                    '<x-filament::button tag="a" href="' . self::getUrl('index') . '?open=create" icon="heroicon-m-plus">Taak toevoegen</x-filament::button>'
                ),
            ]));
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTasks::route('/'),
        ];
    }
}
