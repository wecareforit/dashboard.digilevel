<?php

namespace App\Filament\Clusters\ToolsSettings\Resources;

use App\Filament\Clusters\ToolsSettings;
use App\Filament\Clusters\ToolsSettings\Resources\ToolsBrandsResource\Pages;
use App\Filament\Clusters\ToolsSettings\Resources\ToolsBrandsResource\RelationManagers;
use App\Models\ToolsBrand;
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

//Table
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;


use Filament\Tables\Columns\ImageColumn;

use Filament\Forms\Components\FileUpload;
class ToolsBrandsResource extends Resource
{
    protected static ?string $model = ToolsBrand::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = ToolsSettings::class;
    protected static ? string $navigationGroup = 'Basisgegevens';
    protected static ? string $navigationLabel = 'Merken';
 


    public static function form(Form $form): Form
    {
        return $form
        ->schema([
 
            Forms\Components\TextInput::make('name')
                ->label('Naam')
                ->columnSpan('full') 
                ->required(),

                FileUpload::make('image')->image()->label('Logo / Afbeelding'),

            Forms\Components\Toggle::make('is_active')
                ->label('Zichtbaar  ')   ->inline(false)
                ->default(true) , ]);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')->label('Logo')  
                ->width(100),

                ToggleColumn::make('is_active')
                ->label('Zichbaar')
                ->onColor('success')
    ->offColor('danger')
 
                ->width(100)
                                 

                , TextColumn::make('name')  ->sortable()
                ->label('Naam')         ->searchable(),
 

                 
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(), 
 
            ])
            ->actions([
                Tables\Actions\EditAction::make()->modalHeading('Wijzigen')->modalWidth(MaxWidth::ExtraLarge),
                Tables\Actions\DeleteAction::make()->modalHeading('Verwijderen'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->modalHeading('Verwijder geselecteerde rijen')
                ]),
            ])      
             ->emptyState(view('partials.empty-state')) ;
            ;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageToolsBrands::route('/'),
        ];
    }
}
