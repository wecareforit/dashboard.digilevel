<?php
namespace App\Filament\Resources;

use App\Filament\Resources\LocationResource\Pages\EditLocation;
use App\Filament\Resources\LocationResource\Pages\ListLocations;
use App\Models\Location;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Grid;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class LocationResource extends Resource
{
    protected static ?string $model                 = Location::class;
    protected static bool $shouldRegisterNavigation = true;
    protected static ?string $navigationGroup = 'Mijn bedrijf je';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Section::make()
                    ->schema([Grid::make(2)
                            ->schema([Forms\Components\TextInput::make("name")
                                    ->label("Naam"),

                            ]),

                    ]),

                Forms\Components\Section::make("Locatie gegevens")->schema([Grid::make(4)->schema([Forms\Components\TextInput::make("postal_code")
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

                                $set("address", $data?->street);

                                $set("city", $data?->settlement);

                            }
                        }))->reactive(),

                    Forms\Components\TextInput::make("street")
                        ->label("Adres")
                        ->required()
                        ->columnSpan(2)

                    , Forms\Components\TextInput::make("city")
                        ->label("Plaats"),

                ])]),
            ]);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultPaginationPageOption(100)
            ->paginated([25, 50, 100, 'all'])
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->weight('medium')
                    ->alignLeft()
                    ->label(__('locations.fields.name')),
                TextColumn::make('street')
                    ->searchable()
                    ->weight('medium')
                    ->label(__('locations.fields.address'))
                    ->alignLeft(),
                TextColumn::make('postal_code')
                    ->searchable()
                    ->weight('medium')
                    ->label(__('locations.fields.postal_code'))
                    ->alignLeft(),
                TextColumn::make('workplaces_count')
                    ->label(__('locations.fields.workplaces'))
                    ->counts('workplaces')
                    ->url(fn($record) => EditLocation::getUrl([
                        $record,
                        'activeRelationManager' => 'workplaces',
                    ]) . '#relationManagerWorkplaces')
                    ->alignCenter()
                    ->badge(),
                TextColumn::make('departments_count')
                    ->label(__('locations.fields.departments'))
                    ->counts('departments')
                    ->url(fn($record) => EditLocation::getUrl([
                        $record,
                        'activeRelationManager' => 'departments',
                    ]) . '#relationManagerDepartments')
                    ->alignCenter()
                    ->badge(),
            ])
            ->actions([
                EditAction::make()
                    ->modalHeading('Locatie Bewerken')
                    ->modalDescription('Pas de bestaande locatie aan door de onderstaande gegevens zo volledig mogelijk in te vullen.')
                    ->tooltip('Bewerken')
                    ->label('')
                    ->modalIcon('heroicon-m-pencil-square')
                ,
                DeleteAction::make(),

                RestoreAction::make(),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()->modalHeading('Verwijderen van alle geselecteerde rijen'),
                ]),
            ])->emptyState(view("partials.empty-state"));
    }

    public static function getRelations(): array
    {
        return [
            // 'departments' => DepartmentsRelationManager::class,
            // 'workplaces'  => WorkplacesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListLocations::route('/'),
            //    'create' => CreateLocation::route('/create'),
            'edit'  => EditLocation::route('/{record}/edit'),
        ];
    }

    public static function getModelLabel(): string
    {
        return __('locations.singular');
    }
}
