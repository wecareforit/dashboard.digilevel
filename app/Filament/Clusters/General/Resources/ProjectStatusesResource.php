<?php

namespace App\Filament\Clusters\General\Resources;

use App\Filament\Clusters\General;
use App\Filament\Clusters\General\Resources\ProjectStatusesResource\Pages;
use App\Filament\Clusters\General\Resources\ProjectStatusesResource\RelationManagers;
use App\Models\Statuses;
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
use Filament\Forms\Components\Select;

//tables
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Columns\SelectColumn;




class ProjectStatusesResource extends Resource
{
    protected static ?string $model = Statuses::class;
    protected static ?string $navigationLabel = 'Statussen';
    protected static ? string $navigationGroup = 'Projecten';
    protected static ?string $recordTitleAttribute = 'name';



    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = General::class;


    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->whereIn('model', ['Project','ProjectQuotes']);
    }



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                ->label('Naam')
                    ->maxLength(255)
                    ->columnSpan('full')
                    ->required(),


                Select::make("model")
                    ->label("Onderdeel")
                    ->required()
                    ->reactive()
                    ->options([
                            'Project' => 'Project',
                            'ProjectQuotes' => 'Project Offertes'
                        ]
                    )->columnSpan("full")










            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('name')
            ->label('Naam')
            ->searchable() ,


                SelectColumn::make('model')->label('Onderdeel')
                    ->options([
                        'Project' => 'Project',
                        'ProjectQuotes' => 'Project Offertes'
                    ])



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
'index' => Pages\ManageProjectStatuses::route('/'),
];
}

}
