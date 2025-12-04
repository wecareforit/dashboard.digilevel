<?php
namespace App\Filament\Resources;

use App\Filament\Resources\ProductCategoriesResource\Pages;
use App\Models\ProductCategories;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProductCategoriesResource extends Resource
{
    protected static ?string $model                 = ProductCategories::class;
    protected static bool $shouldRegisterNavigation = false;
    protected static ?string $navigationIcon        = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
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
                Tables\Actions\EditAction::make()
                    ->modalHeading('Productcategorie Bewerken')
                    ->modalDescription('Pas de bestaande productcategorie aan door de onderstaande gegevens zo volledig mogelijk in te vullen.')
                    ->tooltip('Bewerken')
                    ->label('')
                    ->modalIcon('heroicon-m-pencil-square'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListProductCategories::route('/'),
            'create' => Pages\CreateProductCategories::route('/create'),
            'edit'   => Pages\EditProductCategories::route('/{record}/edit'),
        ];
    }
}
