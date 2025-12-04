<?php

namespace App\Filament\Clusters\Logs\Resources;

use App\Filament\Clusters\Logs;
use App\Filament\Clusters\Logs\Resources\ExternalApiLogResource\Pages;
use App\Filament\Clusters\Logs\Resources\ExternalApiLogResource\RelationManagers;
use App\Models\ExternalApiLog;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Filters\SelectFilter;



use App\Enums\ApiStatus;
 

class ExternalApiLogResource extends Resource
{
    protected static ?string $model = ExternalApiLog::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $title = "Externe API Logboek";
    protected static ?string $navigationLabel = "Externe API";

    protected static ?string $cluster = Logs::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

              
             
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                   
                Tables\Columns\TextColumn::make("created_at")
                ->label("Date en Tijd")->dateTime("d-m-Y H:i"),
                
                Tables\Columns\TextColumn::make("model")
                ->label("Categorie"),

                Tables\Columns\TextColumn::make("logitem")
                    ->label("Omschrijving"),
      
                    
                Tables\Columns\TextColumn::make("model_sub")
                    ->label("Leverancier"),
                    
                Tables\Columns\TextColumn::make("status_id")
                ->label("Status")->badge()


            ])      ->poll('10s')  ->defaultSort('created_at','desc')
            ->filters([
                SelectFilter::make("model_sub")
                ->label("Leverancier")
                ->options(
                    [
                        "chex" => "Chex"
                    ]
                )
                ->searchable()
                ->preload(),
            ])
            ->actions([
                 
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
            'index' => Pages\ListExternalApiLogs::route('/'),
           // 'create' => Pages\CreateExternalApiLog::route('/create'),
            //'edit' => Pages\EditExternalApiLog::route('/{record}/edit'),
        ];
    }
}
