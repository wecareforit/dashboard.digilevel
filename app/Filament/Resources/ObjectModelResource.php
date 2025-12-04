<?php
namespace App\Filament\Resources;

use App\Filament\Resources\ObjectModelResource\Pages;
use App\Models\Brand;
use App\Models\ObjectModel;
use App\Models\ObjectType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;

class ObjectModelResource extends Resource
{
    protected static ?string $model = ObjectModel::class;

    protected static ?string $navigationIcon        = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel       = "Object Modellen";
    protected static ?string $title                 = "Object Modellen";
    protected static ?string $pluralModelLabel      = "Object Modellen";
    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\TextInput::make('name')
                    ->label('Naam')
                    ->required()
                    ->columnSpan("full")
                    ->maxLength(255),

                Forms\Components\Select::make("brand_id")
                    ->label("Merk")
                    ->required()
                    ->searchable()
                    ->options(Brand::pluck("name", "id")),

                Forms\Components\Select::make("type_id")
                    ->label("Categorie")
                    ->required()
                    ->searchable()
                    ->options(ObjectType::pluck("name", "id")),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table

            ->groups([

                Group::make('name')
                    ->label('Naam'),

                Group::make('type.name')
                    ->label('Categorie'),

                Group::make('brand.name', )
                    ->label('Merk'),

            ])

            ->columns([

                TextColumn::make('name')
                    ->label('Naam')
                    ->searchable(),

                TextColumn::make('type.name')
                    ->label('Categorie')
                    ->badge()
                    ->placeholder("-")
                    ->sortable()
                    ->searchable(),

                TextColumn::make('brand.name')
                    ->label('Merk')
                    ->placeholder("-")
                    ->sortable()
                    ->searchable(),

            ])
            ->filters([

            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->modalHeading('Model bewerken')
                    ->tooltip('Bewerken')
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListModels::route('/'),
            //  'create' => Pages\CreateModel::route('/create'),
            // 'edit'   => Pages\EditModel::route('/{record}/edit'),
        ];
    }

}
