<?php

namespace App\Filament\Clusters\General\Resources;

use App\Filament\Clusters\General;
use App\Filament\Clusters\General\Resources\ObjectBuildingTypeResource\Pages;
use App\Filament\Clusters\General\Resources\ObjectBuildingTypeResource\RelationManagers;
use App\Models\ObjectBuildingType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;


use Filament\Support\Enums\MaxWidth;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;


class ObjectBuildingTypeResource extends Resource
{
    protected static ?string $model = ObjectBuildingType::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = General::class;


    protected static ?string $title = 'Gebouw types';

    protected static ? string $navigationGroup = 'Objecten';
    protected static ? string $navigationLabel = 'Gebouwtypes';


    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\TextInput::make('name')
            ->label('Omschrijving')
            ->columnSpan('full')  ->required(),

            Forms\Components\Toggle::make('is_active')
            ->label('Zichtbaar  ')
            ->default(true)
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([

            ToggleColumn::make('is_active')
            ->label('Zichbaar')
            ->onColor('success')
->offColor('danger')


            ->width(50),
            TextColumn::make('name')->searchable()   ->sortable()
            ->label('Omschrijving')


        ])
        ->filters([
            Tables\Filters\TrashedFilter::make(),

        ])
        ->actions([
 
           Tables\Actions\EditAction::make()->modalHeading('Wijzigen')
           ->modalWidth(MaxWidth::Large),
           Tables\Actions\DeleteAction::make()
           ->modalHeading('Verwijderen van deze rij'),
        ])
        ->bulkActions([
          Tables\Actions\BulkActionGroup::make([
             Tables\Actions\DeleteBulkAction::make()->modalHeading('Verwijderen van alle geselecteerde rijen'),

         ]),
        ])
         ->emptyState(view('partials.empty-state')) ;
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
            'index' => Pages\ListObjectBuildingTypes::route('/'),
           // 'create' => Pages\CreateObjectBuildingType::route('/create'),
          //  'edit' => Pages\EditObjectBuildingType::route('/{record}/edit'),
        ];
    }
}
