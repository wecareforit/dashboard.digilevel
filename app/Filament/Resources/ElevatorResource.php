<?php
namespace App\Filament\Resources;

use App\Filament\Resources\ElevatorResource\Pages;
use App\Filament\Resources\ElevatorResource\RelationManagers;
use App\Models\Brand;
use App\Models\Customer;
use App\Models\Elevator;
use App\Models\Employee;
use App\Models\ObjectModel;
use App\Models\ObjectType;
use Awcodes\FilamentBadgeableColumn\Components\Badge;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Form;
use Filament\Infolists\Components\SpatieMediaLibraryImageEntry;
use Filament\Infolists\Components\Tabs;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ViewEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Support\Enums\Alignment;
use Filament\Tables;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use Relaticle\CustomFields\Filament\Infolists\CustomFieldsInfolists;

class ElevatorResource extends Resource
{
    protected static ?string $model            = Elevator::class;
    protected static ?string $navigationIcon   = "heroicon-c-arrows-up-down";
    protected static ?string $navigationLabel  = "Objecten";
    protected static ?string $pluralModelLabel = 'Objecten';
    protected static ?string $navigationGroup  = 'Liften';

    protected static ?int $navigationSort           = 2;
    protected static bool $shouldRegisterNavigation = true;
    protected static ?string $recordTitleAttribute  = 'title';
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }


    public static function shouldRegisterNavigation(): bool
    { 
        return setting('module_elevators') ?? false;
    }


    public static function getGlobalSearchResultTitle($record): string
    {
        return $record->name;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Wizard::make([
                    Step::make('Hardware informatie')
                        ->schema([

                            Select::make('type_id')
                                ->label('Categorie')
                                ->options(ObjectType::pluck('name', 'id'))
                                ->reactive()
                                ->required()->afterStateUpdated(function (callable $set) {
                                $set('brand_id', null);
                            }),

                            //     ->createOptionForm([

                            //         TextInput::make('name')
                            //             ->label('Nieuwe categorie naam')
                            //             ->required()
                            //             ->columnSpan('full')
                            //             ->maxLength(50),

                            //         ToggleButtons::make('options')
                            //             ->label('Opties')
                            //             ->multiple()
                            //             ->options([
                            //                 'Keuringen'            => 'Keuringen',
                            //                 'Onderhoudscontracten' => 'Onderhoudscontracten',
                            //                 'Tickets'              => 'Tickets',
                            //                 'Onderhoudsbeurten'    => 'Onderhoudsbeurten',

                            //             ])
                            //             ->required()
                            //             ->inline()
                            //         ,

                            //     ])->createOptionUsing(function (array $data): int {

                            //     return ObjectType::create($data)->getKey();
                            // }),

                            Select::make('brand_id')
                                ->label('Merk')
                                ->options(function (callable $get) {
                                    $type_id = $get('type_id');

                                    return ObjectModel::query()
                                        ->when($type_id, fn($query) => $query->where('type_id', $type_id))
                                        ->get()
                                        ->groupBy('brand_id')
                                        ->map(fn($group) => $group->first()) // Only one per brand
                                        ->filter(fn($item) => $item->brand)  // Ensure brand exists
                                        ->mapWithKeys(fn($item) => [
                                            $item->brand_id => $item->brand->name,
                                        ])
                                        ->toArray();
                                })

                                ->reactive()
                                ->disabled(fn(callable $get) => ! $get('type_id'))
                                ->createOptionForm([
                                    TextInput::make('name')
                                        ->label('Nieuwe merknaam')
                                        ->required()
                                        ->columnSpan('full')
                                        ->maxLength(50),
                                ])->createOptionUsing(function (array $data): int {
                                return Brand::create($data)->getKey();
                            }),

                            Select::make('model_id')
                                ->label('Model')
                                ->options(function (callable $get) {
                                    $type_id  = $get('type_id');
                                    $brand_id = $get('brand_id');

                                    return ObjectModel::query()
                                        ->when($type_id, fn($query) => $query->where('type_id', $type_id)->where('brand_id', $brand_id))
                                        ->get()
                                        ->mapWithKeys(function ($data) {

                                            return [
                                                $data->id => collect([
                                                    $data->name,

                                                ])->filter()->implode(', '),
                                            ];
                                        })
                                        ->toArray();
                                })
                                ->reactive()
                                ->disabled(fn(callable $get) => ! $get('brand_id')),

                            TextInput::make('name')
                                ->label('Naam'),

                        ])->columns(2),

                    Step::make('Toewijzing')
                        ->schema([

                            TextInput::make('serial_number')
                                ->label('Serienummer'),

                            

                            TextInput::make('uuid')
                                ->label('Uniek id nummer')
                                ->hint('Scan een barcode sticker'),
                        ]),

                    Step::make('Opmerking')
                        ->schema([
                            Textarea::make("remark")
                                ->rows(7)
                                ->label('Opmerking')
                                ->columnSpan('full')
                                ->autosize()
                                ->hint(fn($state, $component) => "Aantal karakters: " . $component->getMaxLength() - strlen($state) . '/' . $component->getMaxLength())
                                ->maxlength(255)
                                ->reactive(),
                        ]),
                ])->columnSpanFull(),
                //  ->submitAction(new \Filament\Forms\Components\Actions\ButtonAction('Submit')),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // IconColumn::make('ifMonitoring')
                //     ->trueColor('success')
                //     ->falseColor('warning')
                //     ->trueIcon('heroicon-o-check-badge')
                //     ->boolean()
                //     ->label('Monitoring')
                //     ->alignment(Alignment::Center)
                //     ->falseIcon('heroicon-o-x-mark'),
                Tables\Columns\TextColumn::make("type.name")
                    ->label("type")
                    ->default(0)
                    ->badge()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make("name")
                    ->label("Naam")
                    ->placeholder("-")
                    ->toggleable(),
                Tables\Columns\TextColumn::make("unit_no")
                    ->label("Nummer")
                    ->searchable()
                    ->sortable()
                    ->placeholder("-r")
                    ->toggleable(),
                SpatieMediaLibraryImageColumn::make('objectimage')
                    ->placeholder('Geen')
                    ->label('Afbeelding')
                    ->toggleable()
                    ->limit(2)
                    ->collection('objectimages'),

                Tables\Columns\TextColumn::make("current_inspection_status_id")
                    ->label("KeuringStatus")
                    ->placeholder('-')

                    ->badge(),
                Tables\Columns\TextColumn::make("current_inspection_end_date")
                    ->label("Keuringsdatum")
                    ->placeholder('-')
                    ->sortable()
                    ->date('d-m-Y'),
                Tables\Columns\TextColumn::make("location.address")
                    ->label("Adres")
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make("incidents_count")
                    ->toggleable()
                    ->counts("incidents")
                    ->label("Storingen")
                    ->alignment(Alignment::Center)
                    ->sortable()

                    ->badge(),
                // Tables\Columns\TextColumn::make("nobo_no")
                //     ->toggleable()
                //     ->label("Nobonummer")
                //     ->searchable()
                //     ->placeholder("Geen Nobonummer"),
                // Tables\Columns\TextColumn::make("location")
                //     ->toggleable()
                //     ->getStateUsing(function (Elevator $record): ?string {
                //         if ($record?->location?->name) {
                //             return $record?->location->name;
                //         } else {
                //             return $record?->location?->address . " - " . $record?->location?->zipcode . " " . $record?->location?->place;
                //         }
                //     })
                //   ->label("Locatie")
                // ->description(function (Elevator $record) {
                //     if (! $record?->location?->name) {
                //         return $record?->location?->name;
                //     } else {
                //         return $record->location->address . " - " . $record->location->zipcode . " " . $record->location->place;
                //     }
                // }),
                // Tables\Columns\TextColumn::make("location.zipcode")
                //     ->label("Postcode")
                //     ->searchable()
                //     ->hidden(true),
                // Tables\Columns\TextColumn::make("location.place")
                //     ->toggleable()
                //     ->label("Plaats")
                //     ->searchable(),
                Tables\Columns\TextColumn::make("location.customer.name")
                    ->toggleable()
                    ->searchable()
                    ->label("Relatie")
                    ->placeholder("Niet gekoppeld aan relatie")
                    ->sortable(),

                // Tables\Columns\TextColumn::make("management_company.name")
                //     ->toggleable()
                //     ->label("Beheerder")
                //     ->placeholder("Geen beheerder")
                //     ->sortable(),
                // Tables\Columns\TextColumn::make("maintenance_company.name")
                //     ->searchable()
                //     ->toggleable()
                //     ->hidden(false)
                //     ->placeholder("Geen onderhoudspartij")
                //     ->sortable()
                //     ->label("Onderhoudspartij"),
            ])
            ->filters([
                SelectFilter::make('type_id')
                    ->label('Type')
                // ->options(ObjectType::where('is_active', 1)->where('show_on_resource_page', true)->pluck('name', 'id'))
                ,
                // SelectFilter::make('maintenance_company_id')
                //     ->label('Onderhoudspartij')
                //  ->options(Relation::where('type_id', 1)->pluck("name", "id")),
                // SelectFilter::make('status_id')
                //     ->label("Status")
                //     ->options(ElevatorStatus::class),
                SelectFilter::make('customer_id')
                    ->label('Relatie')
                    ->options(Customer::all()->pluck("name", "id")),
                // SelectFilter::make("current_inspection_status_id")
                //     ->searchable()
                //     ->label("Keuringstatus")
                //     ->options(InspectionStatus::class),
            ], layout: FiltersLayout::AboveContent)
            ->actions([

                Tables\Actions\ViewAction::make('openContact')
                    ->label('Bekijk')
                    ->icon('heroicon-s-eye'),
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make()
                        ->modalHeading('Object Bewerken')
                        ->modalDescription('Pas de bestaande object aan door de onderstaande gegevens zo volledig mogelijk in te vullen.')
                        ->tooltip('Bewerken')
                        ->label('')
                        ->modalIcon('heroicon-m-pencil-square')
                    ,
                    DeleteAction::make()
                        ->modalIcon('heroicon-o-trash')
                        ->tooltip('Verwijderen')
                        ->label('')
                        ->modalHeading('Verwijderen')
                        ->color('danger'),
                ]),
            ])
            ->bulkActions([
                ExportBulkAction::make()
                    ->exports([
                        ExcelExport::make()
                            ->fromTable()
                            ->askForFilename()
                            ->askForWriterType()
                            ->withColumns([
                                Column::make("customer.name")->heading("Relatie"),
                                Column::make("type.name")->heading("Type"),
                                Column::make("unit_no")->heading("Unit no"),
                                Column::make("nobo_no")->heading("Nobo no"),
                                Column::make("energy_label")->heading("Energielael"),
                                Column::make("construction_year")->heading("Bouwjaar"),
                                Column::make("status_id")->heading("Status"),
                                Column::make("supplier.name")->heading("Leverancier"),
                                Column::make("stopping_places")->heading("Stopplaatsen"),
                                Column::make("inspectioncompany.name")->heading("Keuringsinstantie"),
                                Column::make("name")->heading("Naam"),
                                Column::make("management_company.name")->heading("Beheerder"),
                                Column::make("remark")->heading("Opmerking"),
                            ])
                            ->withFilename(date("m-d-Y H:i") . " - objecten export"),
                    ]),
            ])
            ->emptyState(view("partials.empty-state"));
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Tabs::make('Object Details')
                    ->columnSpan('full')
                    ->tabs([
                        Tabs\Tab::make('Basisinformatie')
                            ->icon('heroicon-o-information-circle')
                            ->schema([
                                TextEntry::make('unit_no')
                                    ->label('Unitnummer')
                                    ->placeholder('Niet opgegeven'),
                                TextEntry::make('nobo_no')
                                    ->label('NOBO Nummer')
                                    ->placeholder('Niet opgegeven'),
                                TextEntry::make('type.name')
                                    ->label('Type')
                                    ->badge()
                                    ->color('success')
                                    ->placeholder('Niet opgegeven'),
                                TextEntry::make('name')
                                    ->label('Naam')
                                    ->placeholder('Niet opgegeven'),
                                TextEntry::make('construction_year')
                                    ->label('Bouwjaar')
                                    ->placeholder('Niet opgegeven'),
                                ViewEntry::make('energy_label')
                                    ->view('filament.infolists.entries.energylabel')
                                    ->label('Energielabel')
                                    ->placeholder('Niet opgegeven'),
                                TextEntry::make('status_id')
                                    ->label('Status')
                                    ->badge()
                                    ->placeholder('Niet opgegeven'),
                                TextEntry::make('latestInspection.status_id')
                                    ->label('Keuringsstatus')
                                    ->badge()
                                    ->placeholder('Onbekend')
                                //     ->visible(fn($record) => in_array('Keuringen', $record?->type?->options) ? true : false)
                                // ,
                                // TextEntry::make('current_inspection_end_date')
                                //     ->label('Keuringsverloop datum')
                                //     ->visible(fn($record) => in_array('Keuringen', $record?->type?->options) ? true : false)

                                //     ->date('d-m-Y')
                                //     ->placeholder('Onbekend'),

                            ])->columns(4),

                        Tabs\Tab::make('Locatie & Relatie')
                            ->icon('heroicon-o-map-pin')
                            ->schema([
                                TextEntry::make('address')
                                    ->label('Adres')
                                    ->getStateUsing(function ($record): ?string {
                                        $housenumber = $record?->location?->housenumber ? " " . $record?->location?->housenumber : "";
                                        return $record?->location?->address . $housenumber . " - " . $record?->location?->zipcode . " " . $record?->location?->place;
                                    })
                                    ->placeholder('Niet opgegeven'),
                                TextEntry::make('location.relation.name')
                                    ->label('Relatie')
                                    ->url(fn($record) => "/relations/" . $record?->location?->customer_id)
                                    ->icon('heroicon-c-link')
                                    ->placeholder('Niet opgegeven'),
                                TextEntry::make('stopping_places')
                                    ->label('Stopplaatsen')
                                    ->placeholder('Niet opgegeven'),
                            ])->columns(2),

                        Tabs\Tab::make('Partijen')
                            ->icon('heroicon-o-user-group')
                            ->schema([
                                TextEntry::make('supplier.name')
                                    ->label('Leverancier')
                                    ->placeholder('Niet opgegeven'),
                                TextEntry::make('maintenance_company.name')
                                    ->label('Onderhoudspartij')
                                    ->placeholder('Niet opgegeven'),
                                TextEntry::make('inspectioncompany.name')
                                    ->label('Keuringsinstantie')
                                    ->visible(fn($record) => in_array('Keuringen', $record?->type?->options) ? true : false)

                                    ->placeholder('Niet opgegeven')
                                    ->hidden(),
                                // TextEntry::make('location.management.name')
                                //     ->label('Beheerder')
                                //     ->visible(fn($record) => in_array('Beheerder', $record?->location?->type?->options) ? true : false)

                                // ->visible(function ($record) {

                                //     return in_array('Beheerder', $record?->location->type->options) ? true : false;;
                                // })

                            ])->columns(2),

                        Tabs\Tab::make('Afbeeldingen')
                            ->icon('heroicon-o-photo')

                            ->schema([
                                SpatieMediaLibraryImageEntry::make('objectimage')
                                    ->hiddenLabel()
                                    ->placeholder('Geen afbeeldingen')
                                    ->height(200)
                                    ->ring(5)
                                    ->collection('objectimages'),
                            ]),

                    ]),
                \Filament\Infolists\Components\Section::make()
                    ->schema([
                        // ...

                        TextEntry::make('remark')
                            ->label("Opmerking")
                            ->placeholder("Geen opmerking"),
                    ]),

                // Custom Fields
                CustomFieldsInfolists::make()
                    ->columnSpanFull(),
            ]);

    }

    public static function getRelations(): array
    {
        return [
             RelationManagers\TicketsRelationManager::class,
            RelationManagers\MaintenanceContractsRelationManager::class,
            RelationManagers\MaintenanceVisitsRelationManager::class,
            RelationManagers\inspectionsRelationManager::class,
            //       RelationManagers\ObjectMonitoringRelationManager::class,
            RelationManagers\AttachmentRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            "index"   => Pages\ListElevators::route("/"),
            "view"    => Pages\ViewElevator::route("/{record}"),
            "monitor" => Pages\MonitorElevator::route("/{record}/monitoring"),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ["uuid", "name", "serial_number"];
    }

    public static function getGlobalSearchResultDetails($record): array
    {
        return [
            'Medewerker'  => $record->employee->name ?? "Geen",
            'Serienummer' => $record?->serial_number ?? "-",
            'Categorie'   => $record?->categorie->name ?? "-",
        ];
    }

}
