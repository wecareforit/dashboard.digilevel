<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\RelationDepartmentResource\Pages;
use App\Filament\Admin\Resources\RelationDepartmentResource\RelationManagers;
use App\Models\RelationDepartment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RelationDepartmentResource extends Resource
{
    protected static ?string $model = RelationDepartment::class;

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
            'index' => Pages\ListRelationDepartments::route('/'),
            'create' => Pages\CreateRelationDepartment::route('/create'),
            'edit' => Pages\EditRelationDepartment::route('/{record}/edit'),
        ];
    }
}
