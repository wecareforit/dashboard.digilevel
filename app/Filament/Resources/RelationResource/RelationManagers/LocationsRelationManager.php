<?php
namespace App\Filament\Resources\RelationResource\RelationManagers;

use App\Models\locationType;
use App\Models\Relation;
use App\Models\ObjectBuildingType;
use App\Services\AddressService;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Infolists\Components\Section;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Support\Enums\Alignment;
use Filament\Tables;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Livewire\Attributes\On;

class LocationsRelationManager extends RelationManager
{
    protected static string $relationship = 'locations';
    protected static ?string $title       = 'Locaties';
    protected static ?string $icon        = 'heroicon-o-building-office-2';
    #[On('refreshForm')]
    public function refreshForm(): void
    {
        $this->fillForm();
    }
    public static function getBadge(Model $ownerRecord, string $pageClass): ?string
    {
        return $ownerRecord->locations()->count();
    }

    public function form(Form $form): Form
    {
        return $form->schema([Forms\Components\Section::make()
                ->schema([Grid::make(2)
                        ->schema([Forms\Components\TextInput::make("name")
                                ->label("Naam"),

                        ])]),

            Forms\Components\Section::make("Locatie gegevens")->schema([Grid::make(4)->schema([

                Forms\Components\TextInput::make("zipcode")
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
                    ->columnSpan(3),
                Forms\Components\TextInput::make("place")
                    ->label("Plaats"),
                Forms\Components\Select::make('type_id')
                    ->label('Type')
                    ->default(1)
                    ->options(locationType::pluck('name', 'id')),

   


                Forms\Components\TextInput::make("gps_lon")
                    ->label("GPS longitude")
                    ->hidden()
                    ->columnSpan(1),

            ])]),

            Forms\Components\Section::make("Afbeeldingen")
                ->compact()
                ->schema([
                    SpatieMediaLibraryFileUpload::make('buildingimage')
                        ->responsiveImages()
                        ->image()
                        ->hiddenlabel()
                        ->panelLayout('grid')
                        ->maxFiles(8)
                        ->label('Afbeeldingen')
                        ->multiple()
                        ->collection('locationimages'),
                ])
                ->collapsible()
                ->collapsed(false)
                ->persistCollapsed()
                ->columns(1),

        ])
            ->columns(3);

        // Select::make("management_id")
        //     ->options(Relation::pluck("name", "id"))

        //     ->reactive()
        //     ->searchable()

        //     ->label("Beheerder")

        //     ->visible(function ($record) {
        //         dd($record);
        //         return in_array('Beheerder', $record?->type->options) ? true : false;;
        //     });

        Section::make()
            ->schema([
                Textarea::make("remark")
                    ->rows(7)
                    ->label("Opmerking")
                    ->columnSpan(3)
                    ->autosize()]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->defaultSort('address')
            ->recordUrl(function ($record) {
                return "/relation-locations/" . $record->id;
            })
            ->columns([

                Tables\Columns\TextColumn::make("address")
                    ->toggleable()
                    ->label('Adres')
                    ->sortable()
                    ->getStateUsing(function ($record): ?string {

                        return $record->address . "-" . $record->zipcode . " - " . $record->place;
                    })
                    ->searchable()
                //->label(fn() => "Adres (" . $this->getOwnerRecord()->locations()->count() . ")")
                    ->description(function ($record) {
                        return $record?->name;
                    }),

                Tables\Columns\TextColumn::make("type.name")
                    ->label("Type")
                    ->placeholder("Onbekend")
                    ->searchable()
                    ->badge()
                    ->width(100)
                    ->toggleable(),

                SpatieMediaLibraryImageColumn::make('locationimage')
                    ->label('Afbeelding')
                    ->toggleable()
                    ->limit(2)
                    ->placeholder("-")
                    ->collection('locationimages'),

                Tables\Columns\TextColumn::make("zipcode")
                    ->label("Postcode")
                    ->searchable()
                    ->toggleable()
                    ->hidden(true),

                Tables\Columns\TextColumn::make("place")
                    ->label("Plaats")
                    ->searchable()
                    ->toggleable()
                    ->hidden(true),
                Tables\Columns\TextColumn::make("objects_count")
                    ->counts("objects")
                    ->label("Objecten")
                    ->toggleable()
                    ->sortable()
                    ->badge()
                    ->alignment(Alignment::Center)
                    ->color("success"),

                Tables\Columns\TextColumn::make("notes_count")
                    ->toggleable()
                    ->counts("notes")
                    ->label("Notites")
                    ->sortable()
                    ->badge()
                    ->alignment(Alignment::Center)
                    ->color("success"), Tables\Columns\TextColumn::make("attachments_count")
                    ->toggleable()
                    ->counts("attachments")
                    ->label("Bijlages")
                    ->sortable()
                    ->badge()
                    ->alignment(Alignment::Center)
                    ->toggleable()
                    ->color("success"),
                // Tables\Columns\TextColumn::make("buildingtype.name")
                //     ->toggleable()
                //     ->sortable()
                //     ->label("Gebouwtype")
                //     ->badge()
                //     ->searchable()
                //     ->placeholder("Onbekend"),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Locatie toevoegen')
                    ->icon('heroicon-m-plus')
                    ->modalIcon('heroicon-o-plus')
                    ->slideOver()
                    ->link()
                    ->modalHeading('Locatie toevoegen'),
            ])
            ->actions([

          
                // Tables\Actions\ActionGroup::make([

                //     Tables\Actions\EditAction::make()
                //         ->label('Wijzigen')

                //         ->modalHeading('Locatie wijzigen'),

                //     Tables\Actions\DeleteAction::make()
                //         ->label('Verwijder'),

                //     RestoreAction::make(),
                // ]),

                // Tables\Actions\ViewAction::make('openLocation')
                //     ->label('Bekijk')
                //     ->url(function ($record) {
                //         return "/relation-locations/" . $record->id;
                //     })
                //     ->icon('heroicon-s-eye'),
                Tables\Actions\EditAction::make()
                    ->label('Wijzigen')
                    ->slideover()
                    ->modalHeading('Locatie wijzigen'),

 Tables\Actions\ActionGroup::make([

     
                    Tables\Actions\DeleteAction::make()
                        ->label('Verwijder')   ->modalHeading('Locatie verwijderen'),
                ])

                ,

            ])
            ->emptyState(view("partials.empty-state"));
    }
}
