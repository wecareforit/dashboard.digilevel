<?php

namespace App\Filament\Clusters\ToolsSettings\Resources;

use App\Filament\Clusters\ToolsSettings;
use App\Filament\Clusters\ToolsSettings\Resources\ToolsInspectionMethodsResource\Pages;
use App\Filament\Clusters\ToolsSettings\Resources\ToolsInspectionMethodsResource\RelationManagers;
use App\Models\ToolsInspectionMethod;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;



//Form
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;

//Table
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;



class ToolsInspectionMethodsResource extends Resource
{
    protected static ?string $model = ToolsInspectionMethod::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ? string $navigationGroup = 'Keuringen';
    protected static ? string $navigationLabel = 'Methodes';
    protected static ?string $cluster = ToolsSettings::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
               
            Forms\Components\TextInput::make('name')
            ->label('Naam')
            ->columnSpan('full')->required() ,

        Forms\Components\Toggle::make('is_active')
            ->label('Zichtbaar  ')
            ->default(true) , ]);
           
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            ToggleColumn::make('is_active')
            ->label('Zichbaar')
            ->onColor('success')
->offColor('danger')

            ->width(100) , TextColumn::make('name')
            ->label('Naam')      ->searchable()
            ->sortable()
             
        ])
        ->filters([
            Tables\Filters\TrashedFilter::make(), 

        ])
        ->actions([
            Tables\Actions\EditAction::make()->modalHeading('Wijzigen'),
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
            'index' => Pages\ManageToolsInspectionMethods::route('/'),
        ];
    }
}
