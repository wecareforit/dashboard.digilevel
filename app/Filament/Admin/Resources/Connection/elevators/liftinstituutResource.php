<?php

namespace App\Filament\Admin\Resources\Connection\elevators;

use App\Filament\Admin\Resources\Connection\elevators\liftinstituutResource\Pages;
use App\Filament\Admin\Resources\Connection\elevators\liftinstituutResource\RelationManagers;
use App\Models\Connection\elevators\liftinstituut;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class liftinstituutResource extends Resource
{
    protected static ?string $model = liftinstituut::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\Listliftinstituuts::route('/'),
            'create' => Pages\Createliftinstituut::route('/create'),
            'edit' => Pages\Editliftinstituut::route('/{record}/edit'),
        ];
    }
}
