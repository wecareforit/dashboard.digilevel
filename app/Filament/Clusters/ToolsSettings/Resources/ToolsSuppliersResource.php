<?php

namespace App\Filament\Clusters\ToolsSettings\Resources;

use App\Filament\Clusters\ToolsSettings;
use App\Filament\Clusters\ToolsSettings\Resources\ToolsSuppliersResource\Pages;
use App\Filament\Clusters\ToolsSettings\Resources\ToolsSuppliersResource\RelationManagers;
use App\Models\ToolsSupplier;
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
 

class ToolsSuppliersResource extends Resource
{
    protected static ?string $model = ToolsSupplier::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ? string $navigationGroup = 'Basisgegevens';
    protected static ? string $navigationLabel = 'Leveranciers';
    protected static ?string $cluster = ToolsSettings::class;

    public static function form(Form $form): Form
    {
        return $form
        ->schema([

            
            Forms\Components\Section::make()
                ->schema([
                   
                 
                    Forms\Components\TextInput::make('name')
                    ->label('Naam')
                    
                        ->maxLength(255)
                        ->required(),

                    Forms\Components\TextInput::make('zipcode')
                     
                        ->label('Postcode')
                        ->maxLength(255),
                      

                    Forms\Components\TextInput::make('place')
                    ->label('Plaats')
                        ->maxLength(255),

                
                        Forms\Components\TextInput::make('address')
                        ->label('Adres')
                        ->maxLength(255),
                  
                       // ->content(fn (Customer $record): ?string => $record->updated_at?->diffForHumans()),
                ])
                ->columnSpan(['lg' => 2]),
              //  ->hidden(fn (?Customer $record) => $record === null),


            Forms\Components\Section::make()
                ->schema([

                    Forms\Components\TextInput::make('emailaddress')
                    ->email()
                    ->label('E-mailadres')   ->columnSpan('full') 

                    ->maxLength(255),
                   
                    Forms\Components\TextInput::make('phonenumber')
                    ->label('Telefoonnummer')   ->columnSpan('full')

                    ->maxLength(255),
              

                    
                ])
                ->columns(2)
          ->columnSpan(['lg' => 1]),

        ])
        ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
        
        ->columns([
            Tables\Columns\Layout\Split::make([
                Tables\Columns\Layout\Stack::make([
                    Tables\Columns\TextColumn::make('name')->label('Naam')
                         
                        ->searchable()
                   
                        ->weight('medium')
                        ->alignLeft(),

                    Tables\Columns\TextColumn::make('emailaddress')
                        ->label('Email address')
                        ->searchable()
                    
                        
                        ->alignLeft(),
                ])->space(),

                Tables\Columns\Layout\Stack::make([
                    Tables\Columns\TextColumn::make('address')
                    ->searchable()
                
                    ->weight('medium')
                    ->alignLeft(),

 

                    Tables\Columns\TextColumn::make('zipcode')->state(
                        function (ToolsSupplier $rec) {
                          return $rec->zipcode . " " . $rec->place;
                         }),
 

 


                ])->space(2),


                // Tables\Columns\TextColumn::make('phonenumber')
                // ->label('Telefoonnummer')
                // ->searchable()
                // ->sortable(),

   


            ])->from('md'),
        ])
            ->filters([
                Tables\Filters\TrashedFilter::make(), 
            ])
            ->actions([
                Tables\Actions\EditAction::make()->modalHeading('Wijzigen') ,
                Tables\Actions\DeleteAction::make()->modalHeading('Verwijderen van deze rij'),
             ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->modalHeading('Verwijderen van alle geselecteerde rijen'),
                ]),
            ])   ->emptyState(view('partials.empty-state')) ;
            ;;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageToolsSuppliers::route('/'),
        ];
    }
}
