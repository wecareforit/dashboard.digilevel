<?php
namespace App\Filament\Resources;

use App\Filament\Resources\VehicleResource\Pages;
use App\Filament\Resources\VehicleResource\RelationManagers;
use App\Models\Vehicle;
use App\Services\RDWService;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\SpatieMediaLibraryImageEntry;
use Filament\Infolists\Components\Tabs;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ViewEntry;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Cache;
class VehicleResource extends Resource
{
    protected static ?string $model = Vehicle::class;

    protected static ?string $navigationIcon = 'heroicon-o-truck';

    protected static ?string $navigationLabel       = 'Voertuigen';
    protected static ?string $pluralModelLabel      = 'Voertuigen';
    protected static ?string $title                 = 'Voertuigen';
    protected static ?string $navigationGroup       = 'Mijn bedrijf';
    protected static bool $shouldRegisterNavigation = true;


    public static function getGloballySearchableAttributes(): array
    {
        return ["kenteken"];
    }

    public static function getModelLabel(): string
    {
        return "Voertuig";
    }

    public static function getGlobalSearchResultDetails($record): array
    {

        return [
            'Voertuig' => $record->voertuigsoort . " . $record->handelsbenaming  " . $record?->model,
            'Kleur'    => $record->eerste_kleur,
            'type'     => $record->inrichting,
            //      'Bestuurder' => $record?->managementcompany->name ?? "-",
        ];

    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            Section::make()
                ->collapsible()
                ->description('Live voertuig locatie')
                ->extraAttributes(['class' => 'flush'])
                ->compact()
                ->icon('heroicon-o-map-pin')
                ->schema([
                    ViewEntry::make("imei")
                        ->view("filament.infolists.entries.gpsframe")
                        ->hiddenLabel()
                        ->placeholder("Niet opgegeven"),
                ]),

            Section::make('Afbeeldingen')
                ->schema([
                    SpatieMediaLibraryImageEntry::make('vehicleimage')
                        ->hiddenLabel()
                        ->height(200)
                        ->ring(5)
                        ->disk(tenant_disk())
                        ->collection('vehicleimages')])->collapsible()
                        ->collapsed(false)
                        ->persistCollapsed(),

            Tabs::make('Tabs')->tabs([
                Tabs\Tab::make('Algemeen')
                    ->icon('heroicon-m-bell')
                    ->schema([
                        TextEntry::make('kenteken')
                            ->label('Kenteken')
                            ->placeholder('-'),
                        TextEntry::make('merk')->label('Merk')->placeholder('-'),
                        TextEntry::make('handelsbenaming')->label('Handelsbenaming')->placeholder('-'),
                        TextEntry::make('inrichting')->label('Inrichting')->placeholder('-'),
                        TextEntry::make('eerste_kleur')->label('Eerste Kleur')->placeholder('-'),
                        TextEntry::make('tweede_kleur')->label('Tweede Kleur')->placeholder('-'),
                        TextEntry::make('variant')->label('Variant')->placeholder('-'),
                        TextEntry::make('aantal_deuren')->label('Aantal Deuren')->placeholder('-'),
                        TextEntry::make('aantal_wielen')->label('Aantal Wielen')->placeholder('-'),
                        TextEntry::make('aantal_zitplaatsen')->label('Aantal Zitplaatsen')->placeholder('-'),
                        TextEntry::make('aantal_rolstoelplaatsen')->label('Aantal Rolstoelplaatsen')->placeholder('-'),
                    ])->columns(3),

                Tabs\Tab::make('Datums')
                    ->icon('heroicon-m-bell')
                    ->schema([
                        TextEntry::make('vervaldatum_apk')->label('Vervaldatum APK')->placeholder('-')->date('d-m-Y') ,
                        TextEntry::make('datum_tenaamstelling_dt')->label('Datum Tenaamstelling')->placeholder('-')->date('d-m-Y') ,
                        TextEntry::make('datum_eerste_toelating_dt')->label('Datum Eerste Toelating')->placeholder('-')->date('d-m-Y') ,
                        TextEntry::make('datum_eerste_tenaamstelling_in_nederland')->label('Datum Tenaamstelling in NL')->placeholder('-')->date('d-m-Y') ,
                        TextEntry::make('jaar_laatste_registratie_tellerstand')->label('Jaar Laatste Registratie Tellerstand')->placeholder('-'),
                    ])->columns(3),

                Tabs\Tab::make('Mileu & Moter')
                    ->icon('heroicon-m-bell')
                    ->schema([
                        TextEntry::make('aantal_cilinders')->label('Aantal Cilinders')->placeholder('-'),
                        TextEntry::make('cilinderinhoud')->label('Cilinderinhoud')->placeholder('-'),
                        TextEntry::make('massa_ledig_voertuig')->label('Massa Ledig Voertuig')->placeholder('-'),
                        TextEntry::make('toegestane_maximum_massa_voertuig')->label('Toegestane Maximum Massa Voertuig')->placeholder('-'),
                        TextEntry::make('maximum_massa_trekken_ongeremd')->label('Maximum Massa Trekken Ongeremd')->placeholder('-'),
                        TextEntry::make('maximum_massa_trekken_geremd')->label('Maximum Massa Trekken Geremd')->placeholder('-'),
                        TextEntry::make('technische_max_massa_voertuig')->label('Technische Max Massa Voertuig')->placeholder('-'),
                    ])->columns(3),
            ]),

            Tabs::make('Tabs')->tabs([
                Tabs\Tab::make('Opmerking')
                    ->icon('heroicon-m-bell')
                    ->schema([
                        // ...
                    ]),

                Tabs\Tab::make('Gebruiker')
                    ->icon('heroicon-m-bell')
                    ->schema([
                        TextEntry::make('title')->placeholder('-'),
                        TextEntry::make('title')->placeholder('-'),
                    ]),

                Tabs\Tab::make('Tankpas')
                    ->icon('heroicon-m-bell')
                    ->schema([
                        TextEntry::make('title')->placeholder('-'),
                        TextEntry::make('title')->placeholder('-'),
                    ]),

                Tabs\Tab::make('Lease maatschappij')
                    ->icon('heroicon-m-bell')
                    ->schema([
                        TextEntry::make('title')->placeholder('-'),
                        TextEntry::make('title')->placeholder('-'),
                    ]),
            ]),

        ]);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make("kenteken")
                    ->unique(Vehicle::class, 'kenteken', ignoreRecord: true)
                    ->label("Kenteken")
                    ->required()
                    ->extraInputAttributes(['onInput' => 'this.value = this.value.toUpperCase()'])
                    ->maxlength(10)
                    ->suffixAction(
                        Action::make("searchDataByLicenceplate")
                            ->icon("heroicon-m-magnifying-glass")
                            ->action(function (Get $get, Set $set) {
                                                                           // Format the license plate before searching
                                $formattedLicensePlate = $get("kenteken"); //Vehicle::formatLicensePlate();

                                // Search using the formatted license plate
                                $data = (new RDWService())->GetVehicle($formattedLicensePlate);
                                $data = json_decode($data);

                                if ($data == null) {
                                    Notification::make()
                                        ->warning()
                                        ->title("Geen resultaten")
                                        ->body("Helaas er zijn geen gegevens gevonden bij het kenteken <b>" . $formattedLicensePlate . "</b> Controleer het kenteken en probeer opnieuw.")->send();
                                } else {
                                    // Set the formatted license plate
                                    $set("kenteken", $formattedLicensePlate);

                                    // Set other fields
                                    $set("voertuigsoort", $data[0]?->voertuigsoort ?? 'Onbekend');
                                    $set("handelsbenaming", $data[0]?->handelsbenaming ?? 'Onbekend');
                                    $set("inrichting", $data[0]?->inrichting ?? 'Onbekend');
                                    $set("variant", $data[0]?->variant ?? 'Onbekend');
                                    $set("eerste_kleur", $data[0]?->eerste_kleur ?? 'Onbekend');
                                    $set("vervaldatum_apk", date("Y-m-d", strtotime($data[0]?->vervaldatum_apk_dt ?? 'Onbekend')));
                                    $set("merk", $data[0]?->merk ?? 'Onbekend');
                                    $set("wielbasis", $data[0]?->wielbasis ?? 'Onbekend');
                                    $set("aantal_deuren", $data[0]?->aantal_deuren ?? 'Onbekend');
                                    $set("aantal_wielen", $data[0]?->aantal_wielen ?? 'Onbekend');
                                    $set("lengte", $data[0]?->lengte ?? 'Onbekend');
                                    $set("breedte", $data[0]?->breedte ?? 'Onbekend');
                                    $set("type", $data[0]?->type ?? 'Onbekend');
                                    $set("uitvoering", $data[0]?->uitvoering ?? 'Onbekend');
                                    $set("catalogusprijs", $data[0]?->catalogusprijs ?? 'Onbekend');
                                    $set("aantal_zitplaatsen", $data[0]?->aantal_zitplaatsen ?? 'Onbekend');
                                    $set("aantal_rolstoelplaatsen", $data[0]?->aantal_rolstoelplaatsen ?? 'Onbekend');
                                    $set("image", $data[0]?->image ?? 'Onbekend');
                                    $set("tweede_kleur", $data[0]?->tweede_kleur ?? 'Onbekend');
                                    $set("bruto_bpm", $data[0]?->bruto_bpm ?? 'Onbekend');
                                    $set("datum_tenaamstelling", $data[0]?->datum_tenaamstelling ?? 'Onbekend');
                                    $set("aantal_cilinders", $data[0]?->aantal_cilinders ?? 'Onbekend');
                                    $set("cilinderinhoud", $data[0]?->cilinderinhoud ?? 'Onbekend');
                                    $set("massa_ledig_voertuig", $data[0]?->massa_ledig_voertuig ?? 'Onbekend');
                                    $set("toegestane_maximum_massa_voertuig", $data[0]?->toegestane_maximum_massa_voertuig ?? 'Onbekend');
                                    $set("maximum_massa_trekken_ongeremd", $data[0]?->maximum_massa_trekken_ongeremd ?? 'Onbekend');
                                    $set("maximum_massa_trekken_geremd", $data[0]?->maximum_massa_trekken_geremd ?? 'Onbekend');
                                    $set("technische_max_massa_voertuig", $data[0]?->technische_max_massa_voertuig ?? 'Onbekend');
                                    $set("wacht_op_keuren", $data[0]?->wacht_op_keuren ?? 'Onbekend');
                                    $set("typegoedkeuringsnummer", $data[0]?->typegoedkeuringsnummer ?? 'Onbekend');
                                    $set("openstaande_terugroepactie_indicator", $data[0]?->openstaande_terugroepactie_indicator ?? 'Onbekend');
                                    $set("maximum_ondersteunende_snelheid", $data[0]?->maximum_ondersteunende_snelheid ?? 'Onbekend');
                                    $set("jaar_laatste_registratie_tellerstand", $data[0]?->jaar_laatste_registratie_tellerstand ?? 'Onbekend');
                                    $set("zuinigheidclassificatie", $data[0]?->zuinigheidclassificatie ?? 'Onbekend');
                                    $set("datum_eerste_toelating_dt", date("Y-m-d", strtotime($data[0]?->datum_eerste_toelating_dt ?? 'Onbekend')));
                                    $set("datum_eerste_tenaamstelling_in_nederland", date("Y-m-d", strtotime($data[0]?->datum_eerste_tenaamstelling_in_nederland ?? 'Onbekend')));
                                    $set("datum_tenaamstelling_dt", date("Y-m-d", strtotime($data[0]?->datum_tenaamstelling_dt ?? 'Onbekend')));
                                    $set("vervaldatum_apk_dt", $data[0]?->vervaldatum_apk_dt ?? 'Onbekend');
                                }
                            })
                    ),
                Grid::make(3)
                    ->schema([
                        TextInput::make("voertuigsoort")
                            ->label("Voertuigsoort"),

                        TextInput::make("merk")
                            ->label("Merk"),

                        TextInput::make("handelsbenaming")
                            ->label("Handelsbenaming"),

                        TextInput::make("inrichting")
                            ->label("Inrichting"),

                        TextInput::make("eerste_kleur")
                            ->label("Kleur"),

                        TextInput::make("variant")
                            ->label("Variant"),

                        DatePicker::make("vervaldatum_apk")
                            ->format('d-m-Y')
                            ->label("Vervaldatum APK"),
                    ]),

                Forms\Components\Section::make()
                    ->description('Afbeeldingen van het voertuig')
                    ->compact()
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('vehicleimage')                   
                       ->disk(tenant_disk())      ->panelLayout('grid')
                            ->maxFiles(8)
                            ->label('Afbeeldingen')
                            ->multiple() 
                            ->preserveFilenames()
                            ->previewable()
                            ->maxFiles(8)
                            ->multiple()
                            ->hiddenLabel() 
                            ->reorderable()
                            ->acceptedFileTypes(['image/jpeg', 'image/png'])
                            ->collection('vehicleimages'),
                    ]),

                // Hidden inputs for the remaining columns
                Hidden::make('wielbasis'),
                Hidden::make('aantal_deuren'),
                Hidden::make('aantal_wielen'),
                Hidden::make('lengte'),
                Hidden::make('breedte'),
                Hidden::make('type'),
                Hidden::make('uitvoering'),
                Hidden::make('catalogusprijs'),
                Hidden::make('aantal_zitplaatsen'),
                Hidden::make('aantal_rolstoelplaatsen'),
                Hidden::make('image'),
                Hidden::make('tweede_kleur'),
                Hidden::make('bruto_bpm'),
                Hidden::make('datum_tenaamstelling'),
                Hidden::make('aantal_cilinders'),
                Hidden::make('cilinderinhoud'),
                Hidden::make('massa_ledig_voertuig'),
                Hidden::make('toegestane_maximum_massa_voertuig'),
                Hidden::make('maximum_massa_trekken_ongeremd'),
                Hidden::make('maximum_massa_trekken_geremd'),
                Hidden::make('technische_max_massa_voertuig'),
                Hidden::make('datum_eerste_tenaamstelling_in_nederland'),
                Hidden::make('wacht_op_keuren'),
                Hidden::make('typegoedkeuringsnummer'),
                Hidden::make('openstaande_terugroepactie_indicator'),
                Hidden::make('maximum_ondersteunende_snelheid'),
                Hidden::make('jaar_laatste_registratie_tellerstand'),
                Hidden::make('zuinigheidclassificatie'),
                Hidden::make('datum_tenaamstelling_dt'),
                Hidden::make('datum_eerste_toelating_dt'),
                Hidden::make('vervaldatum_apk_dt'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table

            ->columns([
                // Tables\Columns\TextColumn::make('id')
                //     ->label('#')
                //     ->sortable()
                //     ->getStateUsing(function ($record): ?string {
                //         return sprintf('%06d', $record?->id);
                //     }),

                Tables\Columns\TextColumn::make('kenteken')
                    ->sortable()
                    ->toggleable()
                    ->placeholder('-')
                    ->label('Kenteken'),

                SpatieMediaLibraryImageColumn::make('vehicleimage')
                    ->label('Afbeelding')
                    ->placeholder('-')
                    ->toggleable()
                              ->limit(2)
                    ->collection('vehicleimages'),

                Tables\Columns\TextColumn::make('merk')
                    ->sortable()
                    ->placeholder('-')
                    ->toggleable()
                    ->label('Merk'),

                Tables\Columns\TextColumn::make('handelsbenaming')
                    ->sortable()
                    ->toggleable()
                    ->placeholder('-')
                    ->label('Handelsbenaming'),

                Tables\Columns\TextColumn::make('variant')
                    ->sortable()
                    ->toggleable()
                    ->placeholder('-')
                    ->label('Variant'),

                Tables\Columns\TextColumn::make('inrichting')
                    ->sortable()
                    ->toggleable()
                    ->placeholder('-')
                    ->label('Inrichting'),

                Tables\Columns\TextColumn::make('eerste_kleur')
                    ->sortable()
                    ->placeholder('-')
                    ->toggleable()
                    ->label('Kleur'),

                Tables\Columns\TextColumn::make('vervaldatum_apk')
                    ->color(
                        fn($record) => strtotime($record?->vervaldatum_apk) <
                        time()
                        ? "danger"
                        : "success"
                    )
                    ->date('d-m-Y')
                    ->sortable()
                    ->placeholder('-')
                    ->toggleable()
                    ->label('Vervaldatum APK'),

                Tables\Columns\TextColumn::make('GPSObject.imei')
                    ->sortable()
                    ->toggleable()
                    ->placeholder('Geen tracker gekoppeld')
                    ->badge()
                    ->label('Tracker'),

            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\RestoreAction::make()
                    ->tooltip('Herstellen')
                    ->label('')
                    ->modalDescription(
                        "Weet je zeker dat je dit item wilt herstellen?"
                    ),
                Tables\Actions\ForceDeleteAction::make()
                    ->tooltip('Permanent Verwijderen')
                    ->label('')
                    ->modalDescription(
                        "Weet je zeker dat je dit item permanent wilt verwijderen?"
                    ),
                Tables\Actions\EditAction::make()
                    ->modalHeading('Voertuig Bewerken')
                    ->modalDescription('Pas de bestaande voertuig aan door de onderstaande gegevens zo volledig mogelijk in te vullen.')
                    ->tooltip('Bewerken')
                    ->label('Bewerken')
                    ->modalIcon('heroicon-m-pencil-square')
                ,
                Tables\Actions\DeleteAction::make()
                    ->modalIcon('heroicon-o-trash')
                    ->tooltip('Verwijderen')
                    ->label('')
                    ->modalHeading('Verwijderen')
                    ->color('danger'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ])->emptyState(view("partials.empty-state"));
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\GpsDataRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVehicles::route('/'),
            "view"  => Pages\ViewVehicle::route("/{record}"),
        ];
    }

}
