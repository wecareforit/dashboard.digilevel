<?php

namespace App\Filament\Resources\RelationResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Grouping\Group;
use Filament\Forms\Components\Toggle;
use Illuminate\Database\Eloquent\Model;
use LaraZeus\Tiles\Tables\Columns\TileColumn;
use App\Models\Contact;
use App\Models\relationLocation;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Enums\FiltersLayout;

class PeopleRelationManager extends RelationManager
{
    protected static string $relationship = 'people';
    protected static ?string $title = 'Personen';
    protected static ?string $modelLabel = 'Personen';
    protected static ?string $pluralModelLabel = 'Personen';

    public static function getBadge(Model $ownerRecord, string $pageClass): ?string
    {
        return $ownerRecord->people()
            ->where('type_id', 1)
            ->where('relation_id', $ownerRecord->id)
            ->count();
    }

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('type_id')
                ->label('Categorie / Type')
                ->options([
                    1 => 'Medewerker',
                    2 => 'Contactpersoon',
                ])
                ->default(1)
                ->required(),

            Forms\Components\TextInput::make('first_name')
                ->label('Voornaam')
                ->required(),

            Forms\Components\TextInput::make('last_name')
                ->label('Achternaam')
                ->required(),

            Forms\Components\TextInput::make('email')
                ->label('E-mailadres')
                ->email(),

            Forms\Components\TextInput::make('department')
                ->label('Afdeling'),

            Forms\Components\TextInput::make('function')
                ->label('Functie'),

            Forms\Components\TextInput::make('phone_number')
                ->label('Telefoonnummer')
                ->tel()
                ->regex('/^\+?\d{6,20}$/'),

            Forms\Components\Select::make('location_id')
                ->label('Locatie')
                ->options(fn() => relationLocation::pluck('address', 'id')),

            Toggle::make('show_in_contactlist')
                ->label('Toon in contactpersonen overzicht'),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->defaultGroup('type_id')
            ->groups([
                Group::make('type_id')
                    ->titlePrefixedWithLabel(true)
                    ->getTitleFromRecordUsing(fn($record): string => match ($record->type_id) {
                        1 => 'Medewerker',
                        2 => 'Contactpersoon',
                        default => 'Onbekend',
                    })
                    ->label('Categorie'),
            ])
            ->columns([
                TileColumn::make('name')
                    ->description(fn($record) => $record->function)
                    ->sortable()
                    ->searchable()
                    ->image(fn($record) => $record->avatar)
                    ->label('Naam'),

                TextColumn::make('email')
                    ->placeholder('-')
                    ->searchable()
                    ->url(fn($record) => "mailto:{$record->email}")
                    ->label('E-mailadres'),

                TextColumn::make('department')
                    ->label('Afdeling')
                    ->placeholder('-'),

                TextColumn::make('function')
                    ->placeholder('-')
                    ->searchable()
                    ->sortable()
                    ->label('Functie'),

                
                TextColumn::make('company')
                    ->placeholder('-')
                    ->searchable()
                    ->sortable()
             ->visible(fn (Closure $get) => $get('type_id') === 1)
                    ->label('Functie'),



                TextColumn::make('phone_number')
                    ->placeholder('-')
                    ->searchable()
                    ->url(fn($record) => "tel:{$record?->phone_number}")
                    ->label('Telefoonnummer')
                    ->description(fn($record): ?string => $record?->mobile_number ?? null),

                TextColumn::make('type_id')
                    ->label('Categorie')
                    ->getStateUsing(fn($record) => $record->type_id == 1 ? 'Medewerker' : 'Contactpersoon')
                    ->badge(fn($record) => $record->type_id == 1 ? 'success' : 'primary')
                    ->sortable(),
            ])
            ->filters([
                TrashedFilter::make(),
                SelectFilter::make('type_id')
                    ->label('Categorie')
                    ->options([
                        1 => 'Medewerkers',
                        2 => 'Contactpersonen',
                    ]),
            ], layout: FiltersLayout::Modal)
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Persoon toevoegen')
                    ->slideOver(),
            ])
            ->actions([
                Tables\Actions\Action::make('openObject')
                    ->icon('heroicon-m-eye')
                    ->url(fn($record) => route('filament.app.resources.contacts.view', ['record' => $record]))
                    ->label('Bekijk'),

                Tables\Actions\EditAction::make()
                    ->label('Snel bewerken')
                    ->slideover(),

                Tables\Actions\ActionGroup::make([
                    Tables\Actions\DeleteAction::make()
                        ->label('Verwijder'),
                ]),
            ]);
    }
}
