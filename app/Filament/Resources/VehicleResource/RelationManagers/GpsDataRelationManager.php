<?php
namespace App\Filament\Resources\VehicleResource\RelationManagers;

use App\Models\gpsObjectData;
use App\Services\AddressService;
use App\Services\TomTomService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Table;

class GpsDataRelationManager extends RelationManager
{
    protected static string $relationship = 'gpsData';

    public function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\DateTimePicker::make('dt_server')
                    ->label('Datum'),

                Forms\Components\TextInput::make("zipcode")
                    ->label("Postcode")

                    ->maxLength(255)->suffixAction(Forms\Components\Actions\Action::make("searchAddressByZipcode")
                        ->icon("heroicon-m-magnifying-glass")->action(function (Get $get, Set $set) {
                        $data = (new AddressService())->GetAddress($get("zipcode"), $get("number"));
                        $data = json_decode($data);

                        if (isset($data->error_id)) {
                            Notification::make()
                                ->warning()
                                ->title("Geen resultaten")
                                ->body("Helaas er zijn geen gegevens gevonden bij de postcode <b>" . $get("zipcode") . "</b> Controleer de postcode en probeer opnieuw.")->send();
                        } else {

                            $set("municipalitySubdivision", $data?->municipality);
                            $set("lat", $data?->lat);
                            $set("lng", $data?->lng);
                            $set("streetNameAndNumber", $data?->street);
                            $set("countrySubdivisionName", $data?->municipality);
                            $set("municipalitySubdivision", $data?->settlement);

                        }
                    }))->reactive(),

                Forms\Components\TextInput::make("streetNameAndNumber")
                    ->label("Straatnaam")
                    ->required()
                    ->columnSpan(2),

                Forms\Components\TextInput::make("municipalitySubdivision")
                    ->label("Plaats")
                    ->required()
                    ->columnSpan(2),

                Forms\Components\TextInput::make("lat")
                    ->label("lat"),

                Forms\Components\TextInput::make("lng")
                    ->label("lng"),

                Forms\Components\TextInput::make('km_start')
                    ->label('Begin KM stand')
                    ->suffixAction(Forms\Components\Actions\Action::make("searchAddressByZipcode")
                            ->icon("heroicon-o-arrow-path")
                            ->action(
                                function (Get $get, Set $set) {
                                    $last_km = gpsObjectData::where(
                                        "vehicle_id",
                                        $this->getOwnerRecord()->id
                                    )->max('km_end');
                                    $set("km_start", $last_km);

                                }))->reactive(),

                Forms\Components\TextInput::make('km_end')
                    ->label('Eind KM stand')
                    ->maxLength(255),

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('namne')
            ->columns([

                Tables\Columns\TextColumn::make('dt_server')->label('Datum')->date('d-m-Y H:i'),
                // Tables\Columns\TextColumn::make('dt_tracker')->label('Tijd')->date('H:i'),
                // Tables\Columns\TextColumn::make('lat')->label('lng'),
                // Tables\Columns\TextColumn::make('lng')->label('lng '),
                Tables\Columns\TextColumn::make('km_start')->label('KM Begin ')->placeholder('-'),
                Tables\Columns\TextColumn::make('km_end')->label('KM Eind ')->placeholder('-'),
                Tables\Columns\TextColumn::make('zipcode')->label('Postcode')->placeholder('-'),
                Tables\Columns\TextColumn::make('streetNameAndNumber')->label('Adres'),
                Tables\Columns\TextColumn::make('municipalitySubdivision')->label('Plaats '),

            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->label("Registratie toevoegen"),
            ])
            ->actions([

                EditAction::make()
                    ->modalHeading('Wijzigen')
                    ->modalIcon('heroicon-m-pencil-square')
                    ->label('Wijzigen')
                ,

                DeleteAction::make()
                    ->modalIcon('heroicon-o-trash')
                    ->modalHeading('Verwijderen')
                    ->color('danger'),

                Action::make("searchDataByCoordinates")
                    ->tooltip('Haal de adres gegevens op')
                    ->icon("heroicon-o-arrow-path")
                    ->hiddenLabel()
                    ->action(function ($record) {
                        $response                        = (new TomTomService())->GetAddressByCoordinates($record->lat, $record->lng);
                        $data                            = json_decode($response);
                        $record->streetNameAndNumber     = $data?->streetNameAndNumber ?? null;
                        $record->countryCode             = $data?->countryCode ?? null;
                        $record->municipalitySubdivision = $data?->municipality ?? null;
                        $record->countryCodeISO3         = $data?->countryCodeISO3 ?? null;
                        $record->countrySubdivisionName  = $data?->countrySubdivisionName ?? null;
                        $record->countrySubdivisionCode  = $data?->countrySubdivisionCode ?? null;
                        $record->zipcode                 = $data?->extendedPostalCode ?? null;

                        $record->save();
                    }),
                Action::make("openGoogleMaps")
                    ->tooltip('Haal de adres gegevens op')
                    ->icon("heroicon-o-map-pin")
                    ->label('Bekijk')
                    ->color('success')
                    ->ModalHeading('Bekijk locatie')
                    ->modalContent(fn($record) => view('filament.infolists.entries.gpsframeModal', ['record' => $record]))
                    ->tooltip('Navigeer in google maps naar dit adres'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])

            ->emptyState(view('partials.empty-state'));
    }
}
