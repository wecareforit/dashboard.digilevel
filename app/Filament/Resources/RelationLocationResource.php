<?php
namespace App\Filament\Resources;

use App\Filament\Resources\RelationLocationResource\Pages;
use App\Filament\Resources\RelationLocationResource\RelationManagers;
use App\Models\ObjectBuildingType;
use App\Models\locationType;
use App\Models\relationLocation;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Infolists\Components;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\SpatieMediaLibraryImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Relaticle\CustomFields\Filament\Forms\Components\CustomFieldsComponent;
use Relaticle\CustomFields\Filament\Infolists\CustomFieldsInfolists;

class RelationLocationResource extends Resource
{
    protected static ?string $model                 = relationLocation::class;
    protected static bool $shouldRegisterNavigation = false;
    protected static ?string $navigationIcon        = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel       = "Relaties locaties";
    protected static ?string $pluralModelLabel      = 'Relaties locaties';

    public static function getGloballySearchableAttributes(): array
    {
        return ["name", "address"];
    }

    public static function getGlobalSearchResultDetails($record): array
    {

        return [
            'Adres'     => $record->address . "   " . $record?->housenumber . " " . $record?->place,
            'Beheerder' => $record?->managementcompany->name ?? "-",
        ];

    }

    public static function form(Form $form): Form
    {
        return $form->schema([Forms\Components\Section::make()
                ->schema([Grid::make(2)
                        ->schema([Forms\Components\TextInput::make("name")
                                ->label("Naam"),

                            // Forms\Components\TextInput::make("complexnumber")
                            //     ->label("Complexnumber"),

                            // Select::make("management_id")
                            //     ->options(Company::where('type_id', 2)->pluck("name", "id"))

                            // ->searchable()
                            // ->label("Beheerder")
                            // ->preload(),

                            //     Select::make("customer_id")
                            //         ->searchable()
                            //         ->label("Relatie")
                            //         ->required()
                            //         ->createOptionForm([
                            //             Forms\Components\TextInput::make('name'),
                            //         ])
                            //         ->createOptionUsing(function (array $data) {
                            //             return Relation::create([
                            //                 'name'    => $data['name'],
                            //                 'type_id' => 5,
                            //             ])->id;
                            //         })
                            //         ->options(Relation::where('type_id', 5)

                            //                 ->pluck('name', 'id')),

                            //     Select::make("management_id")
                            //         ->searchable()
                            //         ->label("Beheerder")
                            //         ->preload()
                            //         ->createOptionForm([
                            //             Forms\Components\TextInput::make('name'),
                            //         ])
                            //         ->createOptionUsing(function (array $data) {
                            //             return Relation::create([
                            //                 'name'    => $data['name'],
                            //                 'type_id' => 2,
                            //             ])->id;
                            //         })
                            //         ->options(Relation::where('type_id', 2)->pluck('name', 'id')),

                        ]),

                ]),

            Forms\Components\Section::make("Locatie gegevens")->schema([Grid::make(4)->schema([Forms\Components\TextInput::make("zipcode")
                    ->label("Postcode")
                    ->extraInputAttributes(['onInput' => 'this.value = this.value.toUpperCase()'])

                    ->maxLength(255)->suffixAction(Action::make("searchAddressByZipcode")
                        ->icon("heroicon-m-magnifying-glass")->action(function (Get $get, Set $set) {
                        $data = (new AddressService())->GetAddress($get("zipcode"), $get("number"));
                        $data = json_decode($data);

                        if (isset($data->error_id)) {
                            Notification::make()
                                ->warning()
                                ->title("Geen resultaten")
                                ->body("Helaas er zijn geen gegevens gevonden bij de postcode <b>" . $get("zipcode") . "</b> Controleer de postcode en probeer opnieuw.")->send();
                        } else {

                            $set("place", $data?->municipality);
                            $set("gps_lat", $data?->lat);
                            $set("gps_lon", $data?->lng);
                            $set("address", $data?->street);
                            $set("municipality", $data?->municipality);
                            $set("province", $data?->province);
                            $set("place", $data?->settlement);

                            $set("construction_year", $data?->constructionYear);
                            $set("surface", $data?->surfaceArea);

                            //check building type ifexist
                            $buildTypeExist = ObjectBuildingType::where('name', '=', $data?->purposes[0])->first();
                            if ($buildTypeExist === null) {
                                $buildingTypeId = ObjectBuildingType::insertGetId(['name' => ucfirst($data?->purposes[0])]);

                            } else {
                                $buildingTypeId = $buildTypeExist->id;
                            }

                            $set("building_type_id", $buildingTypeId);

                        }
                    }))->reactive(),

                Forms\Components\TextInput::make("address")
                    ->label("Straatnaam")
                    ->required()
                    ->columnSpan(2),

                // Forms\Components\TextInput::make("housenumber")
                //     ->label("Huisnummer"),

                Forms\Components\TextInput::make("place")
                    ->label("Plaats"), Forms\Components\TextInput::make("province")
                    ->label("Provincie"), Forms\Components\TextInput::make("gps_lat")
                    ->label("GPS latitude")

                    ->columnSpan(1)
                    ->hidden(), Forms\Components\TextInput::make("gps_lon")
                    ->label("GPS longitude")
                    ->hidden()
                    ->columnSpan(1),


                       Select::make("building_type_id")
                                ->options(ObjectBuildingType::pluck("name", "id"))

                                ->reactive()
                                ->searchable()

                                ->label("Gebouwtype"),


                                                Select::make('type_id')
                         ->label('Categorie')
                    ->default(1)
                    ->options(locationType::pluck('name', 'id')),



                            Select::make("management_id")
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
                                ->reactive()
                                ->searchable()
                                             ->columnSpan(2)

                                ->label("Beheerder")

                                ->visible(function (object $record) {
                                    return in_array('Beheerder', $record?->type->options) ? true : false;;
                                })



                // Forms\Components\Checkbox::make("is_standard_location")
                //     ->label("Standaard locatie")
                //     ->default(false)
                //     ->columnSpan('full'),

            ])]),

            // Forms\Components\Section::make("Afbeeldingen gegevens")->collapsible()->schema([Grid::make(4)->schema([

            //     SpatieMediaLibraryFileUpload::make('image')
            //         ->multiple()
            //         ->reorderable()
            //         ->collection('images')
            //         ->responsiveImages(),

            // ])])

            //     ->columns(2)
            //     ->columnSpan(2),

            Forms\Components\Section::make("Afbeeldingen")
                ->description('Afbeeldingen van het gebouw')
                ->compact()
                ->schema([

                    SpatieMediaLibraryFileUpload::make('relationlocationimage')
                        ->responsiveImages()
                        ->image()
                        ->disk(config('filesystems.default'))
                        ->hiddenlabel()
                        ->panelLayout('grid')
                        ->maxFiles(8)
                        ->label('Afbeeldingen')
                        ->multiple()
                        ->collection('location'),

                ])
                ->collapsible()
                ->collapsed(false)
                ->persistCollapsed()

                ->columns(1),

 
  CustomFieldsComponent::make()
                ->columnSpanFull(),

        ])
            ->columns(3);
        // Add the CustomFieldsComponent

        Section::make()
            ->schema([
                Textarea::make("remark")
                    ->rows(7)
                    ->label("Opmerking")
                    ->columnSpan(3)
                    ->autosize(),

            ]);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([

                EditAction::make()
                    ->modalHeading('Locatie Bewerken')
                    ->modalDescription('Pas de bestaande locatie aan door de onderstaande gegevens zo volledig mogelijk in te vullen.')
                    ->tooltip('Bewerken')
                    ->label('')
                    ->modalIcon('heroicon-m-pencil-square')
                ,
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([Section::make()->schema([Components\Split::make([

            Components\Grid::make(4)->schema([

                TextEntry::make("address")

                    ->label("Adres")->getStateUsing(function ($record): ?string {
                    $housenumber = "";
                    if ($record->housenumber) {
                        $housenumber = " " . $record?->housenumber;
                    }

                    return $record?->address . " " . $housenumber . " - " . $record?->zipcode . " " . $record?->place;
                })
                    ->placeholder("Niet opgegeven")

                    ->Url(function (object $record) {
                        return "https://www.google.com/maps/dir/" . $record?->address . "+" . $record?->housenumber . "+" . $record?->zipcode . "+" . $record?->place;
                    })
                    ->icon('heroicon-s-map-pin')
                    ->openUrlInNewTab()

                ,

                TextEntry::make("name")
                    ->label("Complexnaam")
                    ->placeholder("Niet opgegeven"),

                // TextEntry::make("construction_year")
                //     ->label("Bouwjaar")
                //     ->placeholder("Niet opgegeven"),

                TextEntry::make("type.name")
                    ->label("Type")
                    ->badge()
                    ->placeholder("Niet opgegeven"),
                TextEntry::make("buildingtype.name")
                    ->label("Gebouwtype")
                    ->badge()
                    ->placeholder("Niet opgegeven"),

                TextEntry::make("relation.name")
                    ->label("Relatie")
                    ->Url(function (object $record) {
                        return "/relations/" . $record->relation_id . "";
                    })
                    ->icon("heroicon-c-link")
                    ->placeholder("Niet opgegeven"),

                // TextEntry::make("complexnumber")
                //     ->label("Complexnummer")
                //     ->placeholder("Niet opgegeven"),

                TextEntry::make("management.name")
                    ->label("Beheerder")
                    ->Url(function (object $record) {
                        return "/relations/" . $record->management_id . "";
                    })
                    ->icon("heroicon-c-link")

                    ->placeholder("Niet opgegeven")
                    ->visible(function (object $record) {
                        return in_array('Beheerder', $record?->type->options) ? true : false;;
                    }),

                // TextEntry::make("managementcompany.name")
                //     ->label("Beheerder")
                //     ->placeholder("Niet opgegeven")
                //     ->Url(f,

            ]),
            // Custom Fields

        ]),

        ]),

            CustomFieldsInfolists::make()
                ->columnSpanFull(),

            Section::make('Afbeeldingen')
                ->schema([
                    SpatieMediaLibraryImageEntry::make('relationlocationimage')
                        ->hiddenLabel()
                          
                                  ->disk(config('filesystems.default'))
                        ->height(200)
                        ->ring(5)
              
                        ->placeholder('Geen afbeeldingen')
                        ->collection('location')])->collapsible()
                ->collapsed(false)
               
                ->visible(function (object $record) {
                    return in_array('Afbeeldingen', $record?->type?->options) ? true : false;;
                })

                ->persistCollapsed(),
        ])

        ;

    }

    public static function getRelations(): array
    {
        return [

            //   RelationGroup::make('Contacts', [
            RelationManagers\ObjectsRelationManager::class,
            RelationManagers\ContactsRelationManager::class,
            RelationManagers\NotesRelationManager::class,
            //  RelationManagers\ProjectsRelationManager::class,
            RelationManagers\AttachmentsRelationManager::class,
            RelationManagers\TicketsRelationManager::class,

            // ]),
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRelationLocations::route('/'),
            //   'create' => Pages\CreateRelationLocation::route('/create'),
            'view'  => Pages\ViewRelationLocation::route('/{record}'),
            //'edit'  => Pages\EditRelationLocation::route('/{record}/edit'),
        ];
    }


      public static function getModelLabel(): string
    {
        return 'Relatie locatie';
    }


}
