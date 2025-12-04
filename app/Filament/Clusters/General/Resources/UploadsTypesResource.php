<?php

namespace App\Filament\Clusters\General\Resources;

use App\Filament\Clusters\General;
use App\Filament\Clusters\General\Resources\UploadsTypesResource\Pages;
use App\Filament\Clusters\General\Resources\UploadsTypesResource\RelationManagers;
use App\Models\uploadType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Filament\Support\Enums\MaxWidth;

//Form
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\ToggleButtons;
//Table
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Checkbox;
 
use Filament\Tables\Filters\Filter;
 

use Filament\Tables\Filters\TernaryFilter;


//filertd
use Filament\Tables\Filters\SelectFilter;

class UploadsTypesResource extends Resource
{
    protected static ?string $model = uploadType::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = General::class;


    protected static ? string $navigationGroup = 'Basisgegevens';
    protected static ? string $navigationLabel = 'Upload types';


    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\TextInput::make('name')
            ->label('Omschrijving')
            ->columnSpan('full') ,
   
                Checkbox::make('visible_projects')->label('Projecten'),
                Checkbox::make('visible_incidents')->label('Storingen'),
                Checkbox::make('visible_assets')->label('Hardwarebeheer'),
                Checkbox::make('visible_tools')->label('Gereedschap'),
                Checkbox::make('visible_workorders')->label('Werkopdrachten'),
                Checkbox::make('visible_fleet')->label('Voertuigbeheer'),
                Checkbox::make('visible_object_management_companies')->label('Object beheerders'),
                Checkbox::make('visible_object_suppliers')->label('Object leveranciers'),
                Checkbox::make('visible_object_maintenance_companies')->label('Object onderhoudspartijen'),
                Checkbox::make('visible_object_attachments')->label('Object bijlages')
                
             
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
  
 
            TextColumn::make('name')->searchable()
            ->label('Omschrijving'),
 
 
            // TextColumn::make('visible_projects')->label('Projecten')->badge()
            // ->color(fn (string $state): string => match ($state) {
             
            //     '1' => 'success',
            //     '0' => 'danger',
            // })
     
            
          

      
        ])
        ->filters([
           
         
        ])
        ->actions([
           Tables\Actions\EditAction::make()->modalHeading('Wijzigen')->modalWidth(MaxWidth::ExtraLarge),
           Tables\Actions\DeleteAction::make()->modalHeading('Verwijderen van deze rij'),
        ])
        ->bulkActions([
          Tables\Actions\BulkActionGroup::make([
             Tables\Actions\DeleteBulkAction::make()->modalHeading('Verwijderen van alle geselecteerde rijen'),
   
         ]),
        ])      
         ->emptyState(view('partials.empty-state')) ;
        ;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageUploadsTypes::route('/'),
        ];
    }
}
