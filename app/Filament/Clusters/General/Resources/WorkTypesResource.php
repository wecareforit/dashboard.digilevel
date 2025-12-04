<?php

namespace App\Filament\Clusters\General\Resources;

use App\Filament\Clusters\General;
use App\Filament\Clusters\General\Resources\WorkTypesResource\Pages;
use App\Filament\Clusters\General\Resources\WorkTypesResource\RelationManagers;
use App\Models\workType;
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
use Filament\Forms\Components\TimePicker;

//tables
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
 


class WorkTypesResource extends Resource
{
    protected static ?string $model = workType::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Werkomschrijvingen';
    protected static ?string $navigationGroup = 'Algemeen';
    protected static ?string $recordTitleAttribute = 'name';
    protected static ?string $cluster = General::class;

    public static function form(Form $form): Form
    {
        return $form
                 
        ->schema([
            Forms\Components\TextInput::make('name')
                ->label('Naam')
                ->maxLength(255)
                ->columnSpan('full')
                ->required(),

            Forms\Components\TextArea::make('description')
                ->label('Omschrijving')
                ->columnSpan('full') ,
                   
            Forms\Components\TimePicker::make('default_minutes')
                ->displayFormat('H:i')
                ->hoursStep(1)
                ->minutesStep(5)
                ->label('Standaard tijd '),
       
            Forms\Components\Toggle::make('is_active')
                ->label('Zichtbaar  ')
                ->inline(false)
                ->default(true) , 
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
                            ->width(100),
            
                        TextColumn::make('name')
                            ->label('Naam')
                            ->searchable() ,
                
                        TextColumn::make('description')
                            ->label('Omschrijving')
                            ->searchable() ,
            
                        TextColumn::make('default_minutes')
                            ->label('Standaardtijd')
                            ->dateTime($format = 'H:i')               
                            ->searchable()
        
                    ])
                    ->filters([
                        Tables\Filters\TrashedFilter::make(), 
                    ])
                    ->actions([
                        Tables\Actions\EditAction::make()->modalHeading('Wijzigen')   ->modalWidth(MaxWidth::ExtraLarge),
                        Tables\Actions\DeleteAction::make()->modalHeading('Verwijderen van deze rij'),
                    ])
                    ->bulkActions([
                      Tables\Actions\BulkActionGroup::make([
                         Tables\Actions\DeleteBulkAction::make()->modalHeading('Verwijderen van alle geselecteerde rijen'),
               
                        ]),
                    ])  ->emptyState(view('partials.empty-state')) ;
                    ;;
            }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageWorkTypes::route('/'),
        ];
    }
}
