<?php
namespace App\Filament\Resources;

use App\Enums\TimeTrackingStatus;
use App\Filament\Resources\TimeTrackingResource\Pages;
use App\Models\Project;
use App\Models\Relation;
use App\Models\timeTracking;
use App\Models\User;
use App\Models\workorderActivities;
 
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Infolists\Components\Tabs;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Support\Enums\Alignment;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use Filament\Tables\Columns\IconColumn;
use Relaticle\CustomFields\Filament\Forms\Components\CustomFieldsComponent;
   use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
    
class TimeTrackingResource extends Resource implements HasShieldPermissions
{


      public static function getPermissionPrefixes(): array
    {
        return [
            'view',
            'view_any',
            'create',
            'update',
            'delete',
            'delete_any',
            'edit_any',
            'assign_to_user',
        ];

        
     
    }

 



    protected static ?string $model            = TimeTracking::class;
    protected static ?string $navigationIcon   = 'heroicon-o-clock';
    protected static ?string $navigationLabel  = "Tijdregistratie";
    protected static ?string $title            = "Tijdregistratie";
    protected static ?string $pluralModelLabel = 'Tijdregistratie';
    protected static ?string $modelLabel = 'Tijdregistratie';



    public static function shouldRegisterNavigation(): bool
    {
        return setting('use_timetracking') ?? false;
    }

  
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Forms\Components\DatePicker::make('started_at')
                                    ->label('Datum')
                                    ->closeOnDateSelection()
                                    ->default(now())
                                    ->required(),
                                Forms\Components\TimePicker::make('time')
                                    ->label('Tijd')
                                    ->seconds(false)
                                    ->required(),
                                Forms\Components\Select::make("relation_id")
                                    ->label("Relatie")
                                    ->searchable()
                                    ->label("Relatie")
                                    ->options(function () {
                                        return \App\Models\Relation::all()
                                            ->groupBy('type.name')
                                            ->mapWithKeys(function ($group, $category) {
                                                return [
                                                    $category => $group->pluck('name', 'id')->toArray(),
                                                ];
                                            })->toArray();
                                    })
                                    ->searchable()
                                    ->live()

                                    // ->createOptionUsing(function (array $data) {
                                    //     return Relation::create([
                                    //         'name'    => $data['name'],
                                    //         'type_id' => 5,
                                    //     ])->id;
                                    // })
                                    ->options(function () {
                                        return \App\Models\Relation::all()
                                            ->groupBy('type.name')
                                            ->mapWithKeys(function ($group, $category) {
                                                return [
                                                    $category => $group->pluck('name', 'id')->toArray(),
                                                ];
                                            })->toArray();
                                    })

                                    ->placeholder("Niet opgegeven"),
                                Forms\Components\Select::make("project_id")
                                    ->label("Project")
                                    ->searchable()
                                    ->placeholder("Niet opgegeven")
                                    ->options(function (Get $get) {
                                        return Project::where('customer_id', $get('relation_id') ?? null)->pluck('name', 'id');
                                    })
                                    ->searchable()
                                    ->disabled(function (Get $get) {
                                        return Project::where('customer_id', $get('relation_id'))->count() <= 0;
                                    }),
                                Forms\Components\Select::make('status_id')
                                    ->label('Status')
                                    ->options(TimeTrackingStatus::class)
                                    ->default(2)
                                    ->required(),
                                Forms\Components\Select::make('work_type_id')
                                    ->label('Type')
                                    ->searchable()
                                    ->options(workorderActivities::where('is_active', 1)->pluck("name", "id"))
                                    ->required(),
                                TextArea::make('description')
                                    ->label('Omschrijving')
                                    ->required()
                                    ->columnSpan('full'),
                                Forms\Components\Toggle::make('invoiceable')
                                    ->label('Facturabel')
                                    ->default(true),
                            ]),
                    ]),
                // Add the CustomFieldsComponent
                CustomFieldsComponent::make()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table

            ->groups([
                Group::make('weekno')
                    ->label('Weeknummer'),
                Group::make('project.name')
                    ->label('Project'),
                Group::make('relation_id')
                    ->getTitleFromRecordUsing(fn(TimeTracking $record): string => ucfirst($record?->relation?->name))
                    ->label('Relatie'),
                Group::make('status_id')
                    ->label('Status'),
                Group::make('invoiceable')
                    ->label('Facturable'),
            ])
            // ->defaultSort('weekno', 'asc')
            // ->defaultGroup('weekno')
            ->persistSearchInSession()
            ->persistSortInSession()
            ->persistColumnSearchesInSession()
            ->recordClasses(fn($record) =>
                $record->deleted_at ? 'table_row_deleted ' : null
            )
            ->columns([
                TextColumn::make('started_at')
                    ->label('Datum')
                    ->sortable()
                    ->toggleable()
                    ->width(50)
                    ->alignment(Alignment::Center)
                    ->date('d-m-Y')
                    ->placeholder('-')
                    ->searchable(),


                    
                TextColumn::make('time')
                    ->label('Uren')
                    ->getStateUsing(function (timeTracking $record) {
                        $seconds = strtotime($record->time) - strtotime('00:00:00');
                        $hours   = floor($seconds / 3600);
                        $minutes = floor(($seconds % 3600) / 60);
                        return sprintf('%d:%02d', $hours, $minutes);
                    })
                    ->alignEnd()
                // ->summarize(Sum::make()->label('Total'))
                    ->width(20),
                TextColumn::make('weekno')
                    ->label('Week nr.')
                    ->badge()
                    ->width(50)
                    ->placeholder('-')
                    ->alignment(Alignment::Center)
                    ->toggleable()
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('activity.name')
                    ->label('Type')
                    ->badge()
                    ->toggleable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('description')
                    ->label('Omschrijving')
                    ->wrap()
                    ->searchable(),

                TextColumn::make('activity.name')
                    ->label('Activiteit')
                    ->wrap()
                    ->hidden()
                    ->placeholder('-'),

                TextColumn::make('relation.name')
                    ->label('Relatie')
                    ->toggleable()
                    ->sortable()
                    ->placeholder('-')
                    ->searchable()

                    ->url(function ($record) {
                        return "relations/" . $record->relation_id;
                    }),
                TextColumn::make('project.name')
                    ->sortable()
                    ->label('Project')
                    ->toggleable()
                    ->sortable()
                    ->color('primary')
                    ->placeholder('-')
                    ->searchable()
                    ->url(function ($record) {
                        return "projects/" . $record->project_id;
                    }),
                TextColumn::make('status_id')
 
                    ->label('Status')
                    ->badge()
                    ->toggleable()
            

                    ->placeholder('-')
                    ->searchable(),
        IconColumn::make('invoiceable')
                    ->boolean()
                    ->label('Facturabel')
                    ->sortable()
                    ->alignment('center')
                    ->width(100),
 
             

            ])->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('periode_id')
                    ->label('Periode')
                    ->options([
                        '1' => 'Deze week',
                        '2' => 'Deze maand',
                        '3' => 'Dit kwartaal',
                        '4' => 'Dit jaar',
                        '5' => 'Gisteren',
                        '6' => 'Vorige week',
                        '7' => 'Vorige maand',
                        '8' => 'Vorig kwartaal',
                        '9' => 'Vorig jaar',
                    ])
                    ->query(function (\Illuminate\Database\Eloquent\Builder $query, array $data) {
                        $periodes = $data['values'] ?? [];

                        if (empty($periodes)) {
                            return;
                        }

                        $query->where(function ($query) use ($periodes) {
                            foreach ($periodes as $periode) {
                                $query->orWhere(function ($query) use ($periode) {
                                    switch ($periode) {
                                        case '1': // Deze week
                                            $query->whereBetween('started_at', [
                                                now()->startOfWeek(),
                                                now()->endOfWeek(),
                                            ]);
                                            break;
                                        case '2': // Deze maand
                                            $query->whereBetween('started_at', [
                                                now()->startOfMonth(),
                                                now()->endOfMonth(),
                                            ]);
                                            break;
                                        case '3': // Dit kwartaal
                                            $query->whereBetween('started_at', [
                                                now()->startOfQuarter(),
                                                now()->endOfQuarter(),
                                            ]);
                                            break;
                                        case '4': // Dit jaar
                                            $query->whereYear('started_at', now()->year);
                                            break;
                                        case '5': // Gisteren
                                            $query->whereDate('started_at', now()->subDay()->toDateString());
                                            break;
                                        case '6': // Vorige week
                                            $query->whereBetween('started_at', [
                                                now()->subWeek()->startOfWeek(),
                                                now()->subWeek()->endOfWeek(),
                                            ]);
                                            break;
                                        case '7': // Vorige maand
                                            $query->whereBetween('started_at', [
                                                now()->subMonth()->startOfMonth(),
                                                now()->subMonth()->endOfMonth(),
                                            ]);
                                            break;
                                        case '8': // Vorig kwartaal
                                            $query->whereBetween('started_at', [
                                                now()->subQuarter()->startOfQuarter(),
                                                now()->subQuarter()->endOfQuarter(),
                                            ]);
                                            break;
                                        case '9': // Vorig jaar
                                            $query->whereYear('started_at', now()->subYear()->year);
                                            break;
                                    }
                                });
                            }
                        });
                    }),
                SelectFilter::make('relation_id')
                    ->label('Relatie')
                    ->searchable()
                    ->label("Relatie")
                    ->options(function () {
                        return \App\Models\Relation::all()
                            ->groupBy('type.name')
                            ->mapWithKeys(function ($group, $category) {
                                return [
                                    $category => $group->pluck('name', 'id')->toArray(),
                                ];
                            })->toArray();
                    }),


                              SelectFilter::make('user_id')
                    ->label('Medewerker')
                        ->options(User::pluck('name', 'id'))
                    ->default(Auth::id())
                    ->searchable()
                    ->visible(fn () => auth()->user()->can('assign_to_user::tracking')),



 

                Tables\Filters\TrashedFilter::make(),

                SelectFilter::make('project_id')

                    ->searchable()
                    ->label("Relatie")
                    ->options(function () {
                        return \App\Models\Project::all()
                            ->groupBy('customer.name')
                            ->mapWithKeys(function ($group, $data) {
                                return [
                                    $data => $group->pluck('name', 'id')->toArray(),
                                ];
                            })->toArray();
                    })

                    ->label('Project'),
                // SelectFilter::make('status_id')
                //     ->options(TimeTrackingStatus::class)
                //     ->label('Status'),
            ], layout: FiltersLayout::Modal)
            ->filtersFormColumns(3)
            ->actions([
                Tables\Actions\EditAction::make()
                    ->modalHeading('Tijdregistratie Bewerken')
                    
                    ->modalDescription('Pas de bestaande tijdregistratie aan door de onderstaande gegevens zo volledig mogelijk in te vullen.')
                    ->tooltip('Bewerken')
                    ->label('Bewerken')
                    ->modalIcon('heroicon-m-pencil-square')
                 ->visible(fn ($record) => $record?->status_id != TimeTrackingStatus::INVOICED)
                ,

                RestoreAction::make(),

                ActionGroup::make([

                    Tables\Actions\DeleteAction::make()
                        ->modalIcon('heroicon-o-trash')
                        ->tooltip('Verwijderen')

                        ->modalHeading('Verwijderen')
                        ->color('danger'),

                ])                ->visible(fn ($record) => $record?->status_id != TimeTrackingStatus::INVOICED),

                

            ])

            ->bulkActions([
                ExportBulkAction::make()->link()
                    ->exports([

                        ExcelExport::make()
                            ->fromTable()

                            ->withColumns([
                                Column::make("started_at")->heading("Datum")
                                    ->formatStateUsing(fn($state) => date("d-m-Y", strtotime($state))),
                                Column::make("weekno")->heading("Weeknummer"),
                                Column::make("time")->heading("Tijd")
                                    ->formatStateUsing(fn($state) => date("H:i", strtotime($state))),
                                Column::make("description")->heading("Omschrijving"),
                                Column::make("relation.name")->heading("Relatie"),
                                Column::make("project.name")->heading("Project"),
                                Column::make("status_id")->heading("Status"),
                            ])
                            ->withWriterType(\Maatwebsite\Excel\Excel::XLSX)
                            ->withFilename(date("m-d-Y H:i") . " - Tijdregistratie export"),
                    ]),
                BulkAction::make('mark_as_invoiced')
                    ->label('Update status')
                    ->form([
                        Forms\Components\Select::make('status_id')
                            ->options(TimeTrackingStatus::class)
                            ->required(),
                    ])
                    ->link()
                    ->action(function ($records, array $data) {
                        foreach ($records as $record) {
                            $record->update(['status_id' => $data['status_id']]);
                        }
                    })
                    ->requiresConfirmation()
                    ->deselectRecordsAfterCompletion(),

            ])
            ->emptyState(view("partials.empty-state"));
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Tabs::make('Tijdregistratie Details')
                    ->columnSpan('full')
                    ->tabs([
                        Tabs\Tab::make('Basisinformatie')
                            ->icon('heroicon-o-information-circle')
                            ->schema([
                                TextEntry::make('started_at')
                                    ->label('Datum')
                                    ->date('d-m-Y')
                                    ->placeholder('-'),
                                TextEntry::make('time')
                                    ->label('Tijd')
                                    ->placeholder('-'),
                                TextEntry::make('description')
                                    ->label('Omschrijving')
                                    ->placeholder('-'),
                            ])->columns(4),

                        Tabs\Tab::make('Relatie & Project')
                            ->icon('heroicon-o-link')
                            ->schema([
                                TextEntry::make('relation.name')
                                    ->label('Relatie')
                                    ->placeholder('-'),
                                TextEntry::make('project.name')
                                    ->label('Project')
                                    ->placeholder('-'),
                                TextEntry::make('workType.name')
                                    ->label('Type werk')
                                    ->placeholder('-'),
                            ])->columns(4),

                        Tabs\Tab::make('Status & Facturatie')
                            ->icon('heroicon-o-document-text')
                            ->schema([
                                TextEntry::make('status_id')
                                    ->label('Status')
                                    ->badge()
                                    ->placeholder('-'),
                                TextEntry::make('invoiceable')
                                    ->label('Facturabel')
                                    ->formatStateUsing(fn($state) => $state ? 'Ja' : 'Nee')
                                    ->placeholder('-'),
                                TextEntry::make('user.name')
                                    ->label('Medewerker')
                                    ->placeholder('-'),
                            ])->columns(4),
                    ]),
            ]);
    }

    public static function getWidgets(): array
    {
        return [
            TimeTrackingStatsWidget::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTimeTrackings::route('/'),
        ];
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();
        return $data;
    }
}

class TimeTrackingStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        // Get the base query that respects current filters
        $query = $this->getFilteredQuery();

        // Calculate total time
        $totalSeconds = $query->sum(function ($record) {
            return strtotime($record->time) - strtotime('00:00:00');
        });
        $totalHours       = floor($totalSeconds / 3600);
        $remainingMinutes = floor(($totalSeconds % 3600) / 60);

        // Calculate billable time
        $billableSeconds = $query->where('invoiceable', true)->sum(function ($record) {
            return strtotime($record->time) - strtotime('00:00:00');
        });
        $billableHours            = floor($billableSeconds / 3600);
        $billableRemainingMinutes = floor(($billableSeconds % 3600) / 60);

        // Calculate current week time
        $currentWeekSeconds = $query->whereBetween('started_at', [
            now()->startOfWeek(),
            now()->endOfWeek(),
        ])->sum(function ($record) {
            return strtotime($record->time) - strtotime('00:00:00');
        });
        $currentWeekHours            = floor($currentWeekSeconds / 3600);
        $currentWeekRemainingMinutes = floor(($currentWeekSeconds % 3600) / 60);

        return [
            Stat::make('Huidige weeknummer', now()->weekOfYear)
                ->icon('heroicon-o-calendar')
                ->description(now()->format('d-m-Y')),

            Stat::make('Totaal uren (gefilterd)', sprintf('%d:%02d', $totalHours, $remainingMinutes))
                ->description('Totaal van alle gefilterde registraties')
                ->icon('heroicon-o-clock')
                ->color('primary'),

            Stat::make('Factureerbare uren', sprintf('%d:%02d', $billableHours, $billableRemainingMinutes))
                ->description($totalSeconds > 0 ?
                    sprintf('%d%% factureerbaar', round(($billableSeconds / $totalSeconds) * 100)) :
                    'Geen uren')
                ->icon('heroicon-o-currency-euro')
                ->color($billableHours >= $totalHours * 0.8 ? 'success' : 'warning'),

            Stat::make('Deze week', sprintf('%d:%02d', $currentWeekHours, $currentWeekRemainingMinutes))
                ->description(sprintf('Week %d (%s - %s)',
                    now()->weekOfYear,
                    now()->startOfWeek()->format('d-m'),
                    now()->endOfWeek()->format('d-m')))
                ->icon('heroicon-o-calendar-days')
                ->color('info'),
        ];
    }

    protected function getFilteredQuery()
    {
        // This gets the base query with all filters applied
        return $this->filters ? $this->filters->filter($this->getModel()::query()) : $this->getModel()::query();
    }
}
