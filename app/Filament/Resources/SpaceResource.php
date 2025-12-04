<?php
namespace App\Filament\Resources;

use App\Filament\Resources\SpaceResource\Pages;
use App\Filament\Resources\SpaceResource\RelationManagers;
use App\Models\Department;
use App\Models\Location;
use App\Models\Space;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\Tabs;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Support\Enums\Alignment;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SpaceResource extends Resource
{
    protected static ?string $model = Space::class;

    protected static ?string $navigationIcon        = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup       = 'Objecten';
    protected static ?int $navigationSort           = 7;
    protected static ?string $navigationLabel       = "Ruimtes";
    protected static ?string $title                 = "Ruimtes";
    protected static ?string $pluralModelLabel      = 'Ruimtes';
    protected static bool $shouldRegisterNavigation = false;
    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\TextInput::make('name')
                    ->label('Naam')
                    ->columnSpan('full')
                    ->required()
                    ->maxLength(255),

                Forms\Components\Select::make("floor_level")
                    ->label("Verdieping")
                    ->options([
                        '1'  => '1',
                        '2'  => '2',
                        '3'  => '3',
                        '4'  => '4',
                        '5'  => '5',
                        '6'  => '6',
                        '7'  => '7',
                        '8'  => '8',
                        '9'  => '9',
                        '10' => '10',
                        '11' => '11',
                        '12' => '12',
                        '13' => '12',
                        '14' => '13',
                        '15' => '15',
                        '16' => '16',

                    ]
                    ),

                Forms\Components\Select::make("location_id")
                    ->label("Locatie")
                    ->options(
                        Location::pluck("name", "id")
                    ),

                Forms\Components\Select::make("department_id")
                    ->label("Afdeling")
                    ->options(
                        Department::pluck("name", "id")
                    ),

            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Tabs::make('Ruimte Informatie')
                    ->columnSpan('full')
                    ->tabs([
                        Tabs\Tab::make('Algemene informatie')
                            ->icon('heroicon-o-information-circle')
                            ->schema([
                                TextEntry::make('name')->label('Naam')->placeholder('-'),
                            ])->columns(2),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Naam')
                    ->searchable(),
                TextColumn::make('location.name')
                    ->label('Locatie')
                    ->placeholder('-')
                    ->searchable(),
                TextColumn::make('department.name')
                    ->label('Afdeling')
                    ->placeholder('-')
                    ->searchable(),
                TextColumn::make('floor_level')
                    ->label('Verdieping')
                    ->placeholder('-')
                    ->badge()
                    ->alignment(Alignment::Center)
                    ->searchable(),

            ])
            ->filters([

            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->modalHeading('Ruimte Bewerken')
                    ->modalDescription('Pas de bestaande ruimte aan door de onderstaande gegevens zo volledig mogelijk in te vullen.')
                    ->tooltip('Bewerken')
                    ->modalIcon('heroicon-m-pencil-square')
                ,

            ])
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
            RelationManagers\LocationRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSpaces::route('/'),
            'view'  => Pages\ViewSpace::route('/{record}'),
            // 'create' => Pages\CreateSpace::route('/create'),
            // 'edit' => Pages\EditSpace::route('/{record}/edit'),
        ];
    }
}
