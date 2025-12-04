<?php
namespace App\Filament\Resources;

use App\Filament\Resources\DepartmentResource\Pages;
use App\Models\Department;
use App\Models\Location;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;


class DepartmentResource extends Resource
{
    protected static ?string $model = Department::class;

    protected static ?int $navigationSort           = 7;
    protected static ?string $navigationLabel       = "Afdelingen";
    protected static ?string $title                 = "Afdelingen";
    protected static ?string $pluralModelLabel      = 'Afdelingen';
    protected static ?string $navigationGroup = 'Mijn bedrijf';
    protected static bool $shouldRegisterNavigation = true;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Naam')
                    ->columnSpan('full')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make("location_id")
                    ->label("Locatie")
                    ->options(
                        Location::pluck("name", "id")
                    )
                    ->default(Location::orderBy('id')->value('id'))

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
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->modalHeading('Afdeling Bewerken')
                    ->modalDescription('Pas de bestaande afdeling aan door de onderstaande gegevens zo volledig mogelijk in te vullen.')
                    ->tooltip('Bewerken')
                    ->modalIcon('heroicon-m-pencil-square')
                ,
                Tables\Actions\DeleteAction::make()
                    ->modalIcon('heroicon-o-trash')
                    ->tooltip('Verwijderen')
                    ->label('')
                    ->modalHeading('Verwijderen')
                    ->color('danger'),
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
            'index' => Pages\ListDepartments::route('/'),
            //    'create' => Pages\CreateDepartment::route('/create'),
            //    'edit' => Pages\EditDepartment::route('/{record}/edit'),
        ];
    }
}
