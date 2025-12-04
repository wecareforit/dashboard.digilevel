<?php

namespace App\Filament\Resources\RelationResource\RelationManagers;

use App\Models\{
    Brand,
    Employee,
    ObjectModel,
    ObjectType,
    relationLocation
};
use App\Filament\Exports\ObjectsExporter;
use Filament\Actions\Exports\Models\Export;
use Filament\Forms\Components\{
    Checkbox,
    Grid,
    Select,
    Textarea,
    TextInput,
    Wizard,
    Wizard\Step
};
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\{
    ActionGroup,
    CreateAction,
    DeleteAction,
    EditAction,
    ExportBulkAction,
    RestoreAction
};
use Filament\Tables\Columns\{
    TextColumn,
    ViewColumn
};
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Grouping\Group;
use LaraZeus\Tiles\Tables\Columns\TileColumn;
use Illuminate\Database\Eloquent\Model;

class ObjectsRelationManager extends RelationManager
{
    protected static bool $isScopedToTenant = false;
    protected static string $relationship = 'objects';
    protected static ?string $icon = 'heroicon-o-user';
    protected static ?string $title = 'Objecten';

    public static function getBadge(Model $ownerRecord, string $pageClass): ?string
    {
        return $ownerRecord->objects->count();
    }

    public static function canViewForRecord(Model $ownerRecord, string $pageClass): bool
    {
        return in_array('Objecten', $ownerRecord?->type?->options ?? []);
    }

    public function form(Form $form): Form
    {
        return $form->schema([
            Wizard::make([
                Step::make('Hardware informatie')
                    ->schema([
                        Select::make('type_id')
                            ->label('Categorie')
                            ->options(ObjectType::pluck('name', 'id'))
                            ->reactive()
                            ->required(),

                        TextInput::make('brand')
                            ->label('Merk')
                            ->disabled(fn(callable $get) => ! $get('type_id')),

                        TextInput::make('model')->label('Model'),
                        TextInput::make('name')->label('Naam'),
                    ])->columns(2),

                Step::make('Eigenschappen')
                    ->schema([
                        Grid::make(3)->schema([
                            TextInput::make('stopping_places')->label('Aantal stopplaatsen')->integer(),
                            TextInput::make('carrying_capacity')->label('Draaggewicht')->integer(),
                            Select::make('energy_label')
                                ->label('Energielabel')
                                ->searchable()
                                ->options(array_combine(
                                    range('A', 'H'),
                                    range('A', 'H')
                                )),
                            Select::make('drive_type')
                                ->label('Aandrijving')
                                ->searchable()
                                ->options([
                                    'Tractie' => 'Tractie',
                                    'Hydraulisch' => 'Hydraulisch',
                                ]),
                            Checkbox::make('fire_elevator')->inline()->label('Brandweerlift'),
                            Checkbox::make('stretcher_elevator')->inline()->label('Brancardlift'),
                        ]),
                    ])
                    ->visible(fn() => setting('environment_elevator')),

                Step::make('Toewijzing')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('serial_number')->label('Serienummer'),
                            TextInput::make('nobo_no')
                                ->label('Nobonummer')
                                ->visible(fn() => setting('environment_elevator')),
                            Select::make('department_id')
                                ->label('Afdeling')
                                ->options(fn() => $this->ownerRecord?->departments?->pluck('name', 'id') ?? [])
                                ->searchable()
                                ->visible(function ($record, callable $get) {
                                    $objectType = ObjectType::find($get('type_id'));
                                    return in_array('Afdeling', $objectType?->visibility ?? []);
                                })
                                ->placeholder('Selecteer een afdeling'),
                            Select::make('location_id')
                                ->label('Locatie')
                                ->searchable(['name', 'address', 'place'])
                                ->options(
                                    relationLocation::where('relation_id', $this->ownerRecord->id)
                                        ->get()
                                        ->mapWithKeys(fn($loc) => [
                                            $loc->id => "{$loc->name} {$loc->address}",
                                        ])
                                ),
                        ]),
                        TextInput::make('uuid')
                            ->label('Uniek id nummer')
                            ->hint('Scan een barcode sticker'),
                    ]),

                Step::make('Opmerking')
                    ->schema([
                        Textarea::make('remark')
                            ->label('Opmerking')
                            ->rows(7)
                            ->columnSpan('full')
                            ->autosize()
                            ->maxlength(255)
                            ->reactive()
                            ->hint(fn($state, $component) =>
                                "Aantal karakters: " .
                                ($component->getMaxLength() - strlen($state)) .
                                '/' . $component->getMaxLength()
                            ),
                    ]),
            ])->columnSpanFull(),
        ]);
    }

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->groups([
                Group::make('type.name')->label('Categorie'),
                Group::make('brand')->label('Merk'),
                Group::make('model')->label('Model'),
            ])
            ->columns([
                TextColumn::make('type.name')
                    ->label('Categorie')
                    ->badge()
                    ->sortable()
                    ->searchable()
                    ->toggleable(),

                ViewColumn::make('fire_elevator')
                    ->label('Eigenschappen')
                    ->view('filament.tables.columns.elevators.properties')
                    ->sortable()
                    ->searchable()
                    ->toggleable()
                    ->visible(fn() => setting('environment_elevator')),

                TextColumn::make('brand')->label('Merk')->sortable()->searchable()->toggleable(),
                TextColumn::make('model')->label('Model')->sortable()->searchable()->toggleable(),

                TileColumn::make('name')
                    ->label('Naam')
                    ->description(fn($record) => $record->function)
                    ->image(fn($record) => $record->avatar)
                    ->sortable(),

                TextColumn::make('location')
                    ->label('Locatie')
                    ->getStateUsing(fn($record) =>
                        $record?->location?->name ??
                        $record?->location?->address
                    )
                    ->toggleable(),

                TextColumn::make('serial_number')
                    ->label('Serienummer')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
                SelectFilter::make('type_id')
                    ->label('Categorie')
                    ->options(ObjectType::where('is_active', 1)->pluck('name', 'id')),
                SelectFilter::make('location_id')
                    ->label('Locatie')
                    ->options(
                        relationLocation::where('relation_id', $this->ownerRecord->id)
                            ->get()
                            ->mapWithKeys(fn($loc) => [
                                $loc->id => "{$loc->name} {$loc->address}",
                            ])
                    ),
            ])
            ->headerActions([
                CreateAction::make()
                    ->link()
                    ->label('Toevoegen')
                    ->icon('heroicon-m-plus')
                    ->modalHeading('Object aanmaken')
                    ->modalDescription('Koppel vaste objecten aan een locatie of medewerker. Maak eerst een medewerker of locatie aan indien nodig.')
                    ->mutateFormDataUsing(fn(array $data) => array_merge($data, [
                        'customer_id' => $this->ownerRecord?->id,
                    ])),
            ])
            ->actions([
                RestoreAction::make(),
                EditAction::make()
                    ->label('Bewerken')
                    ->tooltip('Bewerken')
                    ->modalHeading('Object bewerken')
                    ->modalDescription('Pas het bestaande object aan door de onderstaande gegevens bij te werken.'),
                ActionGroup::make([
                    DeleteAction::make()
                        ->label('Verwijderen')
                        ->tooltip('Verwijderen')
                        ->modalHeading('Object verwijderen')
                        ->modalIcon('heroicon-o-trash')
                        ->color('danger'),
                ]),
            ])
            ->bulkActions([
                ExportBulkAction::make()
                    ->label('Exporteren')
                    ->exporter(ObjectsExporter::class)
                    ->fileName(fn(Export $export) => "objecten-{$export->getKey()}")
                    ->modalHeading('Exporteer gegevens'),
            ])
            ->emptyState(view('partials.empty-state-small'))
            ->recordUrl(fn($record) => "/objects/{$record->id}");
    }
}
