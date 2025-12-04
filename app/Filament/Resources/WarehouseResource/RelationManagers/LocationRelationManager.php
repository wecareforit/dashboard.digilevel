<?php

namespace App\Filament\Resources\WarehouseResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use App\Models\Location;
use Filament\Facades\Filament;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Grid;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LocationRelationManager extends RelationManager
{
    protected static string $relationship = 'location';

    public function form(Form $form): Form
    {
        return $form
            ->schema([]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Naam')
                    ->searchable(),
                Tables\Columns\TextColumn::make('street')
                    ->label('Straat')
                    ->searchable(),
                Tables\Columns\TextColumn::make('house_number')
                    ->label('Huisnummer')
                    ->searchable(),
                Tables\Columns\TextColumn::make('house_number_addition')
                    ->label('Huisnummer toevoeging')
                    ->searchable(),
                Tables\Columns\TextColumn::make('postal_code')
                    ->label('Postcode')
                    ->searchable(),
                Tables\Columns\TextColumn::make('city')
                    ->label('Stad')
                    ->searchable(),
                Tables\Columns\TextColumn::make('country')
                    ->label('Land')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone_number')
                    ->label('Telefoonnummer')
                    ->searchable(),
            ])
            ->headerActions([
                Action::make('createLocation')
                    ->label('Toevoegen')
                    ->modalHeading('Locatie toevoegen')
                    ->form([
                        Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label('Naam')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('street')
                                    ->label('Straat')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('house_number')
                                    ->label('Huisnummer')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('house_number_addition')
                                    ->label('Huisnummer toevoeging')
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('postal_code')
                                    ->label('Postcode')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('city')
                                    ->label('Stad')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('country')
                                    ->label('Land')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('phone_number')
                                    ->label('Telefoonnummer')
                                    ->maxLength(255),
                            ]),
                    ])
                    ->mutateFormDataUsing(function (array $data): array {
                        // Create the location
                        $location_id = Location::insertGetId([
                            'name'                  => $data['name'],
                            'company_id'            => Filament::getTenant()->id,
                            'street'                => $data['street'],
                            'house_number'          => $data['house_number'],
                            'house_number_addition' => $data['house_number_addition'],
                            'postal_code'           => $data['postal_code'],
                            'city'                  => $data['city'],
                            'country'               => $data['country'],
                            'phone_number'          => $data['phone_number'],
                        ]);

                        // Optionally, you can return the location ID or other data
                        return $data;
                    }),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}