<?php
namespace App\Filament\Resources;

use App\Filament\Resources\SupplierResource\Pages\ListSuppliers;
use App\Filament\Resources\SupplierResource\RelationManagers\CategoriesRelationManager;
use App\Models\Supplier;
use App\Services\AddressService;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Grid;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Infolists\Components;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Actions\RestoreBulkAction;
use Filament\Tables\Table;

class SupplierResource extends Resource
{
    protected static ?string $model                 = Supplier::class;
    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([

            Forms\Components\Section::make()->schema([

                Forms\Components\TextInput::make("name")
                    ->label("Naam / Bedrijfsnaam")
                    ->required()

                    ->columnSpan("full"),

                Grid::make(5)->schema([Forms\Components\TextInput::make("zipcode")
                        ->label("Postcode")
                        ->maxLength(255)
                        ->suffixAction(Action::make("searchAddressByZipcode")
                                ->icon("heroicon-m-magnifying-glass")
                                ->action(function (Get $get, Set $set) {

                                    $data = (new AddressService())->GetAddress($get("zipcode"), $get("number"));
                                    $data = json_decode($data);

                                    if (isset($data->error_id)) {
                                        Notification::make()
                                            ->warning()
                                            ->title("Geen resultaten")
                                            ->body("Helaas er zijn geen gegevens gevonden bij de postcode <b>" . $get("zipcode") . "</b> Controleer de postcode en probeer opnieuw.")->send();
                                    } else {
                                        $set("place", $data?->municipality);
                                        $set("address", $data?->street);
                                        $set("place", $data?->settlement);
                                    }
                                })),

                    Forms\Components\TextInput::make("address")
                        ->label("Adres")
                        ->columnSpan(2),
                    Forms\Components\TextInput::make("place")
                        ->label("Plaats")
                        ->columnSpan(2),

                ])])

            // Forms\Components\Fieldset::make('options')
            //     ->label('zichtbaarheid')
            //     ->schema([
            //         Forms\Components\Toggle::make('show_on_products')
            //             ->label('Keuringen'),
            //         Forms\Components\Toggle::make('show_on_object')
            //             ->label('Storingen'),
            //         Forms\Components\Toggle::make('show_on_object')
            //             ->label('Storingen'),

            //     ])

                ->columnSpan(4),

        ]);

    }

    public static function infolist(Infolist $infolist): Infolist
    {

        return $infolist->schema([

            Components\TextEntry::make('name')
                ->label("Bedrijfsnaam")
                ->placeholder("Niet opgegeven"),

            Components\TextEntry::make("address")
                ->label("Adres")
                ->getStateUsing(function ($record): ?string {

                    return $record?->address . " - " . $record?->zipcode . " " . $record?->place;
                })
                ->placeholder("Niet opgegeven"),

        ]);

    }

    public static function table(Table $table): Table
    {
        return

        $table->

            columns([

            Tables\Columns\TextColumn::make('name')
                ->searchable()
                ->weight('medium')
                ->alignLeft()
                ->placeholder('-')
                ->label('Bedrijfsnaam'),

            Tables\Columns\TextColumn::make('address')
                ->searchable()
                ->label('Adres')
                ->weight('medium')
                ->placeholder('-')
                ->alignLeft(),

            Tables\Columns\TextColumn::make('zipcode')
                ->placeholder('-')
                ->label('Postcode'),

        ])
            ->filters([

                // SelectFilter::make('type_id')
                //     ->label('Categorie')
                //     ->options(SupplierType::class),

                // Tables\Filters\TrashedFilter::make(),

            ],
            )
            ->actions([
                Tables\Actions\EditAction::make()
                    ->modalHeading('Leverancier Bewerken')
                    ->modalDescription('Pas de bestaande leverancier aan door de onderstaande gegevens zo volledig mogelijk in te vullen.')
                    ->tooltip('Bewerken')
                    ->modalIcon('heroicon-m-pencil-square')
                ,
                DeleteAction::make()
                    ->modalIcon('heroicon-o-trash')
                    ->tooltip('Verwijderen')
                    ->label('')
                    ->modalHeading('Verwijderen')
                    ->color('danger'),
                RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make(

                    [Tables\Actions\DeleteBulkAction::make()

                            ->modalHeading('Verwijderen van alle geselecteerde rijen'),

                        RestoreBulkAction::make(),

                    ])])
            ->emptyState(view('partials.empty-state'));
    }
    public static function getRelations(): array
    {
        return [
            CategoriesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSuppliers::route('/'),
            //   'create' => CreateSupplier::route('/create'),
            //   'edit'   => EditSupplier::route('/{record}/edit'),
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Leveranciers';
    }

    public static function getModelLabel(): string
    {
        return 'Leveranciers';
    }
}
