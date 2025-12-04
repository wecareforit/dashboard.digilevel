<?php
namespace App\Filament\Resources;

use App\Filament\Resources\BrandResource\Pages\EditBrand;
use App\Filament\Resources\BrandResource\Pages\ListBrands;
use App\Filament\Resources\BrandResource\RelationManagers;
use App\Models\Brand;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class BrandResource extends Resource
{
    protected static ?string $model                 = Brand::class;
    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Section::make()
                    ->columns(4)
                    ->schema([

                        TextInput::make('name')
                            ->label(__('asset_brands.fields.name'))
                            ->columnSpan('full')

                            ->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultPaginationPageOption(100)
            ->paginated([25, 50, 100, 'all'])
            ->columns([

                TextColumn::make('name')
                    ->label(__('asset_brands.fields.name'))
                    ->searchable()
                    ->placeholder('-')
                    ->sortable(),
                TextColumn::make('models_count')
                    ->label('Modellen')
                    ->counts('models')
                    ->alignCenter()
                    ->badge(),
            ])
            ->actions([
                EditAction::make()
                    ->modalHeading('Merk Bewerken')
                    ->modalDescription('Pas het bestaande merk aan door de onderstaande gegevens zo volledig mogelijk in te vullen.')
                    ->tooltip('Bewerken')
                    ->modalIcon('heroicon-m-pencil-square')
                ,
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
            RelationManagers\ModelsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListBrands::route('/'),
            // 'create' => CreateBrand::route('/create'),
            'edit'  => EditBrand::route('/{record}/edit'),
        ];
    }

    public static function getModelLabel(): string
    {
        return __('asset_brands.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('asset_brands.plural');
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Hardwarebeheer';
    }
}
