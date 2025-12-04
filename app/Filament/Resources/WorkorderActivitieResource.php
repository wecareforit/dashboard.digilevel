<?php
namespace App\Filament\Resources;

use App\Filament\Resources\WorkorderActivitieResource\Pages;
use App\Models\workorderActivities;
use Filament\Forms;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class WorkorderActivitieResource extends Resource
{
    protected static ?string $model = workorderActivities::class;

    protected static ?string $navigationIcon        = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel       = "Type werkzaamheden";
    protected static ?string $title                 = "Type werkzaamheden";
    protected static ?string $pluralModelLabel      = 'Type werkzaamheden';
    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\TextInput::make('name')
                    ->label('Naam')
                    ->required()
                    ->columnSpan('full'), Forms\Components\TimePicker::make('default_time')
                    ->label('Standaard tijd')
                    ->seconds(false)
                ,
                TextArea::make('description')
                    ->label('Omschrijving')
                    ->required()
                    ->columnSpan('full'),

                Forms\Components\Toggle::make('is_active')
                    ->label('Actief')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ToggleColumn::make('is_active')->label('Zichbaar')
                    ->onColor('success')
                    ->offColor('danger')
                    ->width(100),

                TextColumn::make('name')
                    ->placeholder('-')
                    ->label('Naam')
                    ->searchable(),
                TextColumn::make('default_time')
                    ->placeholder('-')
                    ->label('Standaardtijd')
                    ->date("h:s")
                    ->searchable(),
                TextColumn::make('description')
                    ->label('Omschrijving')
                    ->placeholder('-')
                    ->searchable(),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->modalHeading('Type Werkzaamheid Bewerken')
                    ->tooltip('Bewerken')
                    ->label('Bewerken')
                ,
                Tables\Actions\DeleteAction::make()
                    ->modalIcon('heroicon-o-trash')
                    ->tooltip('Verwijderen')
                    ->label('')
                    ->modalHeading('Verwijderen')
                    ->color('danger')])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyState(view('partials.empty-state'));
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
            'index' => Pages\ListWorkorderActivities::route('/'),
            // 'create' => Pages\CreateWorkorderActivitie::route('/create'),
            //  'edit'   => Pages\EditWorkorderActivitie::route('/{record}/edit'),
        ];
    }
}
