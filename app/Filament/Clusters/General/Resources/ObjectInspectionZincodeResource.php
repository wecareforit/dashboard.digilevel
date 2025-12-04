<?php

namespace App\Filament\Clusters\General\Resources;

use App\Filament\Clusters\General;
use App\Filament\Clusters\General\Resources\ElevatorInspectionZincodeResource\Pages;
use App\Filament\Clusters\General\Resources\ElevatorInspectionZincodeResource\RelationManagers;
use App\Models\ElevatorInspectionZincode;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;



use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;


class ElevatorInspectionZincodeResource extends Resource
{
    protected static ?string $model = ElevatorInspectionZincode::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $cluster = General::class;
    protected static ? string $navigationGroup = 'Keuringen';
    protected static ? string $navigationLabel = 'Zin Codes';

    
    public static function form(Form $form): Form
    {
        return $form
        ->schema([

            Forms\Components\TextInput::make('code')
            ->label('Code')
            ->columnSpan('full') ,

            Forms\Components\Textarea::make('description')
            ->label('Omschrijving')
            ->columnSpan('full') 

        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
 
                             



    TextColumn::make('code')->searchable()
       
            ->width(100) ,  

            TextColumn::make('description')->searchable()
            ->label('Omschrijving')   ->wrap()
          
      
        ])
        ->filters([
            Tables\Filters\TrashedFilter::make(), 

        ])
        ->actions([
           // Tables\Actions\EditAction::make()->modalHeading('Wijzigen'),
        //   Tables\Actions\DeleteAction::make()->modalHeading('Verwijderen van deze rij'),
        ])
        ->bulkActions([
           Tables\Actions\BulkActionGroup::make([
         //     Tables\Actions\DeleteBulkAction::make()->modalHeading('Verwijderen van alle geselecteerde rijen'),
   
          ]),
        ])      
         ->emptyState(view('partials.empty-state')) ;
        ;
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
            'index' => Pages\ListElevatorInspectionZincodes::route('/'),
          //  'create' => Pages\CreateElevatorInspectionZincode::route('/create'),
          //  'edit' => Pages\EditElevatorInspectionZincode::route('/{record}/edit'),
        ];
    }
}
