<?php
namespace App\Filament\Resources;

use App\Filament\Resources\LocationTypeResource\Pages;
use App\Models\locationType;
use Filament\Forms;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class LocationTypeResource extends Resource
{
    protected static ?string $model = locationType::class;

    protected static ?string $navigationIcon        = 'heroicon-o-rectangle-stack';
    protected static bool $shouldRegisterNavigation = false;
    protected static ?string $navigationLabel       = "Locatie types";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                Section::make('Modules')
                    ->description('Een selectie van de modules voor deze locatie type')
                    ->schema([

                        CheckboxList::make('options')::make('options')
                            ->label('Opties')

                            ->options([
                                'Afbeeldingen'    => 'Afbeeldingen',
                                'Contactpersonen' => 'Contactpersonen',
                                'Notities'        => 'Notities',
                                'Bijlages'        => 'Bijlages',
                                'Beheerder'       => 'Beheerder',
                                'Objecten'        => 'Objecten',
                                'Tickets'         => 'Tickets',
                            ])
                            ->required()
                            ->columns(2),

                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('options')
                    ->label('Opties')
                    ->badge(),

            ])
            ->filters([
                //
            ])
            ->actions([

                Tables\Actions\EditAction::make()
                    ->modalHeading('Relatie type')
                    ->modalDescription('Pas het bestaande object type aan door de onderstaande gegevens zo volledig mogelijk in te vullen.')
                    ->label('Bewerken')
                    ->modalIcon('heroicon-m-pencil-square')
                ,
                Tables\Actions\DeleteAction::make()
                    ->modalIcon('heroicon-o-trash')
                    ->tooltip('Verwijderen')
                    ->label('')
                    ->modalHeading('Verwijderen')
                    ->color('danger'),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])->emptyState(view('partials.empty-state'));

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
            'index' => Pages\ListRelationTypes::route('/'),
            //  'create' => Pages\CreateRelationType::route('/create'),
            //  'edit'   => Pages\EditRelationType::route('/{record}/edit'),
        ];
    }
}
