<?php
namespace App\Filament\Resources;

use App\Filament\Resources\ProjectsResource\Pages;
use App\Filament\Resources\ProjectsResource\RelationManagers;
use App\Models\Employee;
use App\Models\Project;
use App\Models\ProjectStatus;
use App\Models\Relation;
use App\Models\relationLocation;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\Tabs;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Support\Enums\VerticalAlignment;
use Filament\Tables;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use Relaticle\CustomFields\Filament\Forms\Components\CustomFieldsComponent;
use Relaticle\CustomFields\Filament\Infolists\CustomFieldsInfolists;
use Pelmered\FilamentMoneyField\Forms\Components\MoneyInput;
use Filament\Forms\Components\Actions\Action;

class ProjectsResource extends Resource
{
    protected static ?string $model                = Project::class;
    protected static ?string $title                = "Projecten";
    protected static ?string $SearchResultTitle    = "Projecten";
    protected static ?string $navigationLabel      = "Projecten";
    protected static ?string $navigationIcon       = "heroicon-o-archive-box";
    protected static bool $isLazy                  = false;
    protected static ?int $navigationSort          = 90;
    protected static ?string $pluralModelLabel     = 'Projecten';
    protected static ?string $recordTitleAttribute = 'name';

    protected $listeners = ["refresh" => '$refresh'];


    public static function shouldRegisterNavigation(): bool
    {
        return setting('use_projects') ?? false;
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'customer.name'];
    }

    public static function getGlobalSearchResultDetails($record): array
    {
        return [
            'Nummer'  => sprintf("%05d", $record?->id),
            'Relatie' => $record?->customer?->name ?? "Onbekend",
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                
                Forms\Components\Section::make()
                    ->schema([
                        Grid::make([
                            "default" => 2,
                            "sm"      => 2,
                            "md"      => 2,
                            "lg"      => 2,
                            "xl"      => 2,
                            "2xl"     => 2,
                        ])->schema([

                              TextInput::make("id")
                     
                        ->registerActions([
                            $editAction = Action::make('enableNotes')
                                ->label('Edit')
                                ->icon('heroicon-o-pencil-square')
                                ->action(fn (TextInput $component) => $component->disabled(false)),
                        ])
                        ->suffixAction($editAction)
 

                       ->label('Projectnummer')
                        ->numeric()
                        ->minValue(0)
                        ->default(fn () => Project::max('id') + 1)
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->helperText('Dit projectnummer moet uniek zijn.'),


                            Forms\Components\Textarea::make("name")
                                ->label("Omschrijving")
                                ->maxLength(255)
                                ->required()
                                ->columnSpan("full"),
                                Forms\Components\Textarea::make("description")
                                ->label("Opmerking")
                                ->columnSpan("full"),
                        ]),
                    ])
                    ->columnSpan(["lg" => 2]),

                Forms\Components\Section::make()
                    ->schema([
                        Grid::make([
                            "default" => 2,
                            "sm"      => 2,
                            "md"      => 2,
                            "lg"      => 2,
                            "xl"      => 2,
                            "2xl"     => 2,
                        ])->schema([
                            TextInput::make("budget_costs")
                                ->label("Budget")
                                ->numeric()
                                ->minValue(0)
                                ->suffixIcon("heroicon-o-currency-euro"),
                            Select::make("status_id")
                                ->label("Status")
                                ->reactive()
                                ->options(ProjectStatus::pluck('name', 'id'))
                                ->default(1),

                            Select::make("customer_id")
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
                               

                            //     ->afterStateUpdated(function (callable $set) {
                            //         $set('location_id', null);
                            //         $set('contact_id', null);
                            //     })
                            //                                   ->reactive(),

                            // Select::make("location_id")
                            //     ->label('Locatie')
                            //     ->searchable()
                            //     ->options(function (callable $get) {
                            //         $relationId = $get('customer_id');

                            //         return relationLocation::query()
                            //             ->when($relationId, fn($query) => $query->where('relation_id', $relationId))
                            //             ->get()
                            //             ->mapWithKeys(function ($location) {
                            //                 return [
                            //                     $location->id => collect([
                            //                         $location->address,
                            //                         $location->zipcode,
                            //                         $location->place,
                            //                     ])->filter()->implode(', '),
                            //                 ];
                            //             })
                            //             ->toArray();
                            //     })

                            //        ->reactive()
                            //   //  ->disabled(fn(callable $get) => ! $get('customer_id'))
                            //     ->placeholder('Selecteer een locatie'),

                            // // return relationLocation::query()
                            // //
                            // //     ->get()

                            ,Select::make("contact_id")
                                ->options(function (callable $get) {
                                    $relationId   = $get('customer_id');
                                    $locationData = relationLocation::whereId($get('location_id'))->first();

                                    //                $managementId =
                                    return Employee::query()
                                    // ->when($relationId, fn($query) => $query->where('relation_id', $relationId))
                                        ->when($relationId, fn($query) => $query->whereIn('relation_id', [$relationId, $locationData?->management_id]))
                                        ->get()

                                        ->mapWithKeys(function ($contact) {
                                            return [
                                                $contact->id => collect([
                                                    $contact->first_name,
                                                    $contact->last_name,
                                                ])->filter()->implode(' '),
                                            ];
                                        })
                                        ->toArray();

                                })
                                ->searchable()

                               ->reactive()
                               ->label('Contactpersoon')
                        ]),
                    ])->columnSpan("full"),

                Forms\Components\Section::make()
                    ->schema([
                        Grid::make([
                            "default" => 2,
                            "sm"      => 2,
                            "md"      => 2,
                            "lg"      => 2,
                            "xl"      => 2,
                            "2xl"     => 2,
                        ])->schema([
                            DatePicker::make("requestdate")->label("Aanvraagdatum"),
                            DatePicker::make("date_of_execution")
                                ->label("Plandatum")
                                ->placeholder('Onbekend'),
                            DatePicker::make("startdate")->label("Startdatum"),
                            DatePicker::make("enddate")->label("Einddatum"),
                        ]),
                    ]),

                CustomFieldsComponent::make()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {

        return $table
            ->defaultSort('id', 'decs')
            ->persistSortInSession()
            ->persistSearchInSession()
            ->searchable()
            ->persistColumnSearchesInSession()

            ->columns([
                Tables\Columns\TextColumn::make("id")
                    ->label("#")
                    // ->getStateUsing(function (Project $record): ?string {
                    //     return sprintf("%05d", $record?->id);
                    // })
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->wrap()
                    ->verticalAlignment(VerticalAlignment::Start),

            //     Tables\Columns\TextColumn::make("contact.name")
            //   ->toggleable(isToggledHiddenByDefault: true)
            //         ->Url(function ($record) {
            //             return "/contacts/" . $record->contact_id . "";
            //         })
            //         ->placeholder('-')
            //         ->label("Contactpersoon"),

                Tables\Columns\TextColumn::make("name")
                    ->label("Omschrijving")
                    ->searchable()
                    ->toggleable()
                    ->wrap()
                    ->description(function (Project $record) {
                        if (! $record?->description) {
                            return false;
                        } else {
                            return $record->description;
                        }
                    })
                    ->verticalAlignment(VerticalAlignment::Start),

                Tables\Columns\TextColumn::make("customer.name")
                    ->getStateUsing(function (Project $record): ?string {
                        return $record?->customer?->name;
                    })
                    ->url(function (Project $record) {
                        return "/relations/" . $record->customer_id;
                    })
                    ->color('primary')
                    ->searchable()
                    ->placeholder('-')
                    ->sortable()
                    ->verticalAlignment(VerticalAlignment::Start)
                    ->label("Relatie")
                           ->toggleable(isToggledHiddenByDefault: true)
                    ->description(function (Project $record) {
                        if (! $record?->contact?->name) {
                            return null;
                        } else {
                            return  $record?->contact?->name;
                        }
                    }),

                Tables\Columns\TextColumn::make("startdate")
                    ->label("Looptijd")
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->getStateUsing(function (Project $record): ?string {
                        $startdate = $record->startdate ? date("d-m-Y", strtotime($record?->startdate)) : "nodate";
                        $enddate   = $record->enddate ? date("d-m-Y", strtotime($record?->enddate)) : "nodate";

                        if ($record->enddate || $record->$startdate) {
                            return $startdate . " - " . $enddate;
                        } else {
                            return "";
                        }
                    })
                    ->toggleable()
                    ->placeholder('Onbekend')
                    ->searchable(),

                Tables\Columns\TextColumn::make("date_of_execution")
                    ->label("Plandatum")
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->getStateUsing(function (Project $record): ?string {
                        if ($record->date_of_execution) {
                            return date("d-m-Y", strtotime($record?->date_of_execution));
                        } else {
                            return false;
                        }
                    })
                    ->toggleable()
                    ->placeholder('Onbekend')
                    ->searchable()
                    ->color(fn($record) => strtotime($record?->date_of_execution) < time() ? "danger" : "success"),

                Tables\Columns\TextColumn::make("status.name")
                    ->label("Status")
                    ->sortable()
                    ->toggleable()
                    ->badge(),

                Tables\Columns\TextColumn::make('quotes_count')
                    ->counts('quotes')
                    ->toggleable()
                    ->sortable()
                    ->badge()
                    ->label("Offertes")
                    ->alignment('center'),

                Tables\Columns\TextColumn::make('budget_costs')
                    ->toggleable()
                    ->sortable()
                    ->placeholder("-")
                    ->money('EUR')
                    ->label("Budget")
                    ->alignment('center'),

     
                Tables\Columns\TextColumn::make('cost_price')
                    ->toggleable()
                    ->placeholder( "-")
                    ->sortable()
                    ->money('EUR')
                    ->label("Kosten")
                    ->alignment('center'),

                Tables\Columns\TextColumn::make('objects_count')
                    ->counts('objects')
                    ->badge()
                    ->label("Objecten")
                    ->toggleable()
                    ->alignment('center'),

                Tables\Columns\TextColumn::make('reactions_count')
                    ->counts('reactions')
                    ->badge()
                    ->label("Reacties")
                    ->toggleable()
                    ->alignment('center'),
            ])
            ->filters([
                SelectFilter::make("status_id")
                    ->label("Status")
                    ->options(ProjectStatus::pluck('name', 'id'))
                    ->searchable()

                    ->preload(),
                SelectFilter::make("customer_id")
                    ->label("Relatie")
                    ->placeholder("Selecteer een relatie")
                    ->options(Relation::get()->pluck("name", "id"))
                    ->searchable()
                    ->preload(),

            ], layout: FiltersLayout::Modal)
            ->filtersFormColumns(4)

            ->actions([

                ViewAction::make()
                    ->label('Bekijk')
                    ->modalIcon('heroicon-o-eye'),

                Tables\Actions\EditAction::make()
                    ->modalHeading('Project Bewerken')
                    ->modalDescription('Pas de bestaande project aan door de onderstaande gegevens zo volledig mogelijk in te vullen.')
                    ->tooltip('Bewerken')
                    ->label('Bewerken')
                    ->slideOver()
                    ->modalIcon('heroicon-m-pencil-square')
                ,

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    ExportBulkAction::make(),
                ]),

            ])

            ->emptyState(view('partials.empty-state')
            )
        ;

    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
            
                         Section::make()
                             ->schema([
                              TextEntry::make('name')
                                    ->label('Omschrijving')
                                    ->placeholder('-')
                             ]),

                Tabs::make('Project Details')
                    ->columnSpan('full')
                    ->tabs([
                        Tabs\Tab::make('Algemene Informatie')
                            ->icon('heroicon-o-information-circle')
                            ->schema([
             

                                   TextEntry::make('customer.name')
                                    ->label('Relatie')
                                    ->icon("heroicon-c-link")
                                    ->Url(function ($record) {
                                        return "/relations/" . $record->customer_id . "";
                                    })
                                    ->placeholder('-'),
                                    
                                TextEntry::make('contact.name')
                                    ->label('Contactpersoon')
                                    ->icon("heroicon-c-link")
                                    ->Url(function ($record) {
                                        return "/contacts/" . $record->contact_id . "";
                                    })
                                    ->placeholder('-'),

                                TextEntry::make('status.name')
                                    ->label('Status')
                                    ->badge()
                                    ->placeholder('-'),
                                
                                    TextEntry::make('cost_price')
                                    ->label('Budget')
                                    ->money('EUR')
                                      ->label('Kosten')
                                    ->placeholder('-'),
                                TextEntry::make('budget_costs')
                                    ->label('Budget')
                                    ->money('EUR')
                                    ->placeholder('-'),

                            ])->columns(4),

                        
                        Tabs\Tab::make('Planning')
                            ->icon('heroicon-o-calendar')
                            ->schema([
                                TextEntry::make('requestdate')
                                    ->label('Aanvraagdatum')
                                    ->date('d-m-Y')
                                    ->placeholder('-'),
                                TextEntry::make('date_of_execution')
                                    ->label('Plandatum')
                                    ->date('d-m-Y')
                                    ->color(fn($state) => strtotime($state) < time() ? 'danger' : 'success')
                                    ->placeholder('-'),
                                TextEntry::make('startdate')
                                    ->label('Startdatum')
                                    ->date('d-m-Y')
                                    ->placeholder('-'),
                                TextEntry::make('enddate')
                                    ->label('Einddatum')
                                    ->date('d-m-Y')
                                    ->placeholder('-'),
                            ])->columns(2),

                        Tabs\Tab::make('Statistieken')
                            ->icon('heroicon-o-chart-bar')
                            ->schema([
                                TextEntry::make('quotes_count')
                                    ->label('Aantal offertes')
                                    ->badge()
                                    ->placeholder('0'),
                                TextEntry::make('reactions_count')
                                    ->label('Aantal reacties')
                                    ->badge()
                                    ->placeholder('0'),
                                TextEntry::make('timeTrackings_count')
                                    ->label('Uren geregistreerd')
                                    ->badge()
                                    ->placeholder('0'),
                            ])->columns(3),
                    ]),

                Section::make()
                    ->visible(fn($record) => $record?->description ?? false)

                    ->schema([
                        // ...

                        TextEntry::make('description')
                            ->label("Opmerking")

                            ->placeholder("Geen opmerking"),
                    ]),

                CustomFieldsInfolists::make()
                    ->columnSpanFull(),
            ]);
    }

    public static function getRelations(): array
    {
        return [

            RelationManagers\ObjectsRelationManager::class,
            RelationManagers\ReactionsRelationManager::class,
            RelationManagers\TimeTrackingRelationManager::class,
            RelationManagers\QuotesRelationManager::class,
            RelationManagers\AttachmentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            "index" => Pages\ListProjects::route("/"),
            'view'  => Pages\ViewProjects::route('/{record}'),
        ];
    }
}
