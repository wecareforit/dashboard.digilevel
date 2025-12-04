<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ElevatorInspectionZinResource\Pages;
use App\Filament\Resources\ElevatorInspectionZinResource\RelationManagers;
use App\Models\ElevatorInspectionZin;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;

class ElevatorInspectionZinResource extends Resource
{
    protected static ?string $model = ElevatorInspectionZin::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel       = "Keuring ZIN Codes";
    protected static ?string $title                 = "Keuring ZIN Codes";
    protected static ?string $pluralModelLabel      = "Keuring ZIN Codes";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')
                    ->label('Code')
                    ->width(20)
                    ->badge()
                    ->searchable(),
                TextColumn::make('description')
                    ->label('Omschrijving')
                    ->wrap()
                    ->searchable(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
             ])->emptyState(view("partials.empty-state"));
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
            'index' => Pages\ListElevatorInspectionZins::route('/'),
        //   'create' => Pages\CreateElevatorInspectionZin::route('/create'),
        //   'edit' => Pages\EditElevatorInspectionZin::route('/{record}/edit'),
        ];
    }
}
