<?php

namespace App\Filament\Resources\RelationResource\RelationManagers;

use App\Enums\Priority;
use App\Enums\TaskTypes;
use App\Models\{Contact, Employee, ObjectLocation, Project, RelationLocation, Task, User};
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\{DatePicker, Section, Select, Textarea, TimePicker, ToggleButtons};
use Filament\Forms\Get;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\{
    Action,
    ActionGroup,
    CreateAction,
    DeleteAction,
    DeleteBulkAction,
    EditAction,
    RestoreAction,
    RestoreBulkAction
};
use Filament\Tables\Columns\{ImageColumn, TextColumn};
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\{SelectFilter, TrashedFilter};
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Relaticle\CustomFields\Filament\Forms\Components\CustomFieldsComponent;

class TasksRelationManager extends RelationManager
{
    protected static string $relationship = 'tasks';
    protected static ?string $icon = 'heroicon-o-rectangle-stack';
    protected static ?string $title = 'Mijn taken';

    public static function getBadge(Model $ownerRecord, string $pageClass): ?string
    {
        return $ownerRecord->tasks()->where('employee_id', auth()->id())->count();
    }

    public static function isBadgeLive(): bool
{
    return true; 
}


    public function form(Form $form): Form
    {
        return $form->schema([
            Textarea::make('description')
                ->rows(3)
                ->label('Uitgebreide omschrijving')
                ->helperText(str('Beschrijf de actie of taak ')->inlineMarkdown()->toHtmlString())
                ->columnSpanFull()
                ->autosize(),

            // Select::make('location_id')
            //     ->label('Locatie')
            //     ->options(fn () => RelationLocation::query()
            //         ->where('relation_id', $this->getOwnerRecord()->id)
            //         ->get()
            //         ->mapWithKeys(fn ($location) => [
            //             $location->id => collect([
            //                 $location->address,
            //                 $location->zipcode,
            //                 $location->place,
            //             ])->filter()->implode(', '),
            //         ])
            //         ->toArray()
            //     )
            //     ->reactive()
            //     ->visible(fn () => setting('tasks_in_location') ?? false)
            //     ->placeholder('Selecteer een locatie'),

            // Select::make('model_id')
            //     ->options(Project::pluck('name', 'id'))
            //     ->visible(fn (Get $get) => $get('model') === 'project')
            //     ->label('Project'),

            // Select::make('model_id')
            //     ->options(Contact::pluck('first_name', 'id'))
            //     ->searchable()
            //     ->visible(fn (Get $get) => $get('model') === 'contactperson')
            //     ->label('Contactpersoon'),

            // Select::make('model_id')
            //     ->options(ObjectLocation::pluck('name', 'id'))
            //     ->visible(fn (Get $get) => $get('model') === 'location')
            //     ->label('Locatie'),

            Select::make('employee_id')
                ->options(User::pluck('name', 'id'))
                ->default(Auth::id())
                ->visible(fn () => auth()->user()->can('assign_to_employee_task'))
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

    public function table(Table $table): Table
    {
        return $table
            ->defaultSort('id', 'desc')
                 ->modifyQueryUsing(fn ($query) =>
                $query->where('employee_id', auth()->id())  
            )
            ->persistSortInSession()
            ->searchable()
            ->persistSearchInSession()
            ->persistColumnSearchesInSession()
            ->description('Overzicht van alle taken die aan jou zijn toegewezen.')
                  ->recordClasses(fn ($record) => 
            $record->deadline && strtotime($record->deadline) < now()->timestamp
                ? 'table_row_deleted'
                : null
            )  ->columns([
                ImageColumn::make('employee.avatar')
                    ->size(30)
                    ->tooltip(fn ($record) => $record?->employee?->name)
                    ->label(''),

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

                TextColumn::make('description')
                    ->label('Taak')
                    ->grow()
                    ->toggleable()
                   ->description(fn ($record) =>
                        'Door: ' . ($record?->make_by_employee?->name ?? 'Onbekend') .
                        ' op ' . ($record?->created_at?->translatedFormat('d F Y') ?? '-') .
                        ' om ' . ($record?->created_at?->translatedFormat('H:i') ?? '-')
                    )

                    ->placeholder('-'),

                TextColumn::make('begin_date')
                    ->label('Plandatum')
                    ->placeholder('-')
                    ->sortable()
                    ->dateTime('d-m-Y')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('deadline')
                    ->label('Einddatum')
                    ->placeholder('-')
                    ->sortable()
                    ->dateTime('d-m-Y')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->color(fn ($record) =>
                        strtotime($record?->deadline) < now()->timestamp ? 'danger' : 'success'
                    ),
            ])
            ->headerActions([
                CreateAction::make()
                    ->modalWidth(MaxWidth::FourExtraLarge)
                    ->modalHeading('Taak toevoegen')
                    ->modalDescription('Voeg een nieuwe taak toe door de onderstaande gegevens zo volledig mogelijk in te vullen.')
                    ->icon('heroicon-m-plus')
                    ->modalIcon('heroicon-o-plus')
                    ->label('Taak toevoegen')
                    ->link()
                    ->slideover()
                    ->mutateFormDataUsing(fn (array $data): array => [
                        ...$data,
                        'relation_id' => $this->getOwnerRecord()->id,
                        'employee_id'    => auth()->id(),
                    ]),
            ])
            ->filters([
                SelectFilter::make('relation_id')
                    ->label('Relatie')
                    ->searchable()
                    ->options(fn () => \App\Models\Relation::all()
                        ->groupBy('type.name')
                        ->mapWithKeys(fn ($group, $category) => [
                            $category => $group->pluck('name', 'id')->toArray(),
                        ])
                        ->toArray()
                    ),
                TrashedFilter::make(),
            ], layout: FiltersLayout::Modal)
            ->filtersFormColumns(3)
            ->actions([
                EditAction::make()
                    ->modalHeading('Taak Bewerken')
                    ->modalDescription('Pas de bestaande taak aan door de onderstaande gegevens zo volledig mogelijk in te vullen.')
                    ->tooltip('Bewerken')
                    ->slideOver()
                    ->visible(fn () => auth()->user()->can('edit_any_task'))
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
                    ->visible(fn ($record) =>
                        auth()->user()->can('compleet_any_task')
                        || $record->employee_id === auth()->id()
                    )
                    ->action(fn ($record) =>
                        $record->update(['deleted_at' => Carbon::now()])
                    ),

                ActionGroup::make([
                    DeleteAction::make()->tooltip('Verwijderen')->label('Verwijderen'),
                    RestoreAction::make()
                        ->color('danger')
                        ->modalHeading('Actie terugplaatsen')
                        ->modalDescription('Weet je zeker dat je deze actie wilt activeren?'),
                ])->visible(fn ($record) =>
                    auth()->user()->can('delete_any_task')
                    || $record->employee_id === auth()->id()
                ),
            ])  ->emptyState(view('partials.empty-state'))
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    DeleteBulkAction::make()->label('Geselecteerde verwijderen'),
                ]),
            ]);
    }
}
