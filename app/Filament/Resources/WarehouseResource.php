<?php
namespace App\Filament\Resources;

use App\Filament\Resources\WarehouseResource\Pages;
use App\Models\Location;
use App\Models\warehouse;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class WarehouseResource extends Resource
{
    protected static ?string $model = warehouse::class;

    protected static ?string $navigationIcon        = 'heroicon-o-rectangle-stack';
    protected static ?int $navigationSort           = 7;
    protected static ?string $navigationLabel       = "Magazijnen";
    protected static ?string $title                 = "Magazijnen";
    protected static ?string $pluralModelLabel      = 'Magazijnen';
    protected static ?string $navigationGroup       = 'Mijn bedrijf';
    protected static bool $shouldRegisterNavigation = true;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\TextInput::make('name')
                    ->label('Naam')
                    ->required()
                    ->columnSpan("full")
                    ->maxLength(255),

                Forms\Components\Select::make("location_id")
                    ->label("Locatie")
                    ->options(
                        Location::pluck("name", "id")
                    )->columnSpan("full"),
                Forms\Components\Toggle::make('is_active')
                    ->label('Actief')
                    ->default(Location::orderBy('id')->value('id'))


            ]);
    }

    //public static function infolist(Infolist $infolist): Infolist
    //{
    // return $infolist
    //     ->schema([
    //         Tabs::make('Magazijn Informatie')
    //             ->columnSpan('full')
    //             ->tabs([
    //                 Tabs\Tab::make('Algemene informatie')
    //                     ->icon('heroicon-o-information-circle')
    //                     ->schema([
    //                         TextEntry::make('name')->label('Naam')->placeholder('-'),
    //                         TextEntry::make('is_active')->label('Actief')->placeholder('-'),
    //                     ])->columns(2),
    //             ]),
    //     ]);
    //}

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ToggleColumn::make('is_active')->label('Zichbaar')
                    ->onColor('success')
                    ->offColor('danger')
                    ->width(100),
                TextColumn::make('name')
                    ->label('Naam')
                    ->searchable(),

                TextColumn::make('location.name')
                    ->label('Locatie')
                    ->placeholder("-")
                    ->searchable(),

            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->modalHeading('Magazijn Bewerken')
                    ->modalDescription('Pas de bestaande magazijn aan door de onderstaande gegevens zo volledig mogelijk in te vullen.')
                    ->tooltip('Bewerken')
                    ->label('')
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
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ])
            ->emptyState(view('partials.empty-state'));
    }
    public static function getRelations(): array
    {
        return [
            //  RelationManagers\LocationRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWarehouses::route('/'),
            // 'view'   => Pages\ViewWarehouse::route('/{record}'),
            // 'create' => Pages\CreateWarehouse::route('/create'),
            //'edit'   => Pages\EditWarehouse::route('/{record}/edit'),
        ];
    }
}
