<?php
namespace App\Filament\Resources\ObjectLocationResource\RelationManagers;

use App\Enums\ElevatorStatus;
use App\Models\ObjectType;
use App\Models\Relation;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Support\Enums\Alignment;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

//Form

//Table

class ObjectsRelationManager extends RelationManager
{
    protected static string $relationship = 'Objects';
    protected static ?string $title       = 'Objecten';
    protected static ?string $icon        = 'heroicon-o-arrows-up-down';

    public static function getBadge(Model $ownerRecord, string $pageClass): ?string
    {
        // $ownerModel is of actual type Job
        return $ownerRecord->objects->count();

    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([

                Grid::make([
                    'default' => 2,

                ])
                    ->schema([

                        Forms\Components\TextInput::make("name")
                            ->label("Naam"),

                        Forms\Components\TextInput::make('unit_no')

                            ->numeric()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('nobo_no')
                            ->required()
                            ->numeric()
                            ->maxLength(255),

                        Select::make('object_type_id')
                            ->label('Type')
                            ->options(ObjectType::where('is_active', 1)->pluck('name', 'id')),

                        Select::make('maintenance_company_id')
                            ->label('Onderhoudspartij')
                            ->createOptionForm([
                                Forms\Components\TextInput::make('name'),
                            ])
                            ->createOptionUsing(function (array $data) {
                                return Relation::create([
                                    'name'    => $data['name'],
                                    'type_id' => 1,
                                    //             'company_id' => Filament::getTenant()->id,
                                ])->id;
                            })
                            ->options(Relation::where('type_id', 1)->pluck("name", "id")),

                        Select::make('status_id')
                            ->label("Status")
                            ->required()
                            ->default(1)
                            ->options(ElevatorStatus::class),

                    ]),

            ]);

    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('unit_no')
                    ->label('Nummer')->searchable()->sortable()
                    ->placeholder('Geen unitnummer'),

                Tables\Columns\TextColumn::make('name')
                    ->label('Naam')->placeholder('-'),

                Tables\Columns\TextColumn::make('nobo_no')
                    ->label('Nobonummer')->searchable()
                    ->placeholder('Geen Nobonummer'),

                TextColumn::make('inspections_count')->counts('inspections')
                    ->label('Keuringen')
                    ->sortable()
                    ->badge()
                    ->alignment(Alignment::Center),

                TextColumn::make('maintenance_count')->counts('maintenance')
                    ->label('Onderhoudsbeurten')
                    ->sortable()
                    ->badge()
                    ->alignment(Alignment::Center),

                Tables\Columns\TextColumn::make('type.name')
                    ->label('Type')->searchable()
                    ->badge()
                    ->placeholder('Onbekend'),

//                Tables\Columns\TextColumn::make('location.managementcompany.name')
//                    ->searchable()
//                    ->label('Beheerder') ->placeholder('Geen beheerder')->sortable() ,

                Tables\Columns\TextColumn::make('maintenance_company.name')
                    ->searchable()->placeholder('Geen onderhoudspartij')
                    ->sortable()
                    ->label('Onderhoudspartij'),

            ])->emptyState(view('partials.empty-state-small'))
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->label('Object toevoegen')
                    ->modalHeading('Object toevoegen')

                    ->modalDescription('Om een object toe te voegen en te koppelen aan deze locatie zijn er een aantal gegevens nodig. Na het opslaan kan je meer gegevens aanpassen van dit object ')
                ,
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->color('warning')
                    ->label('Open object')->url(function (object $record) {
                    return "/objects/" . $record->id . "";
                })->icon('heroicon-c-link'),

                ActionGroup::make([

                    EditAction::make(),
                    DeleteAction::make(),
                ]),

                //->url(fn (Object $record): string => route('filament.resources.object.edit', $record))
                //->openUrlInNewTab()
                //    Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
//                Tables\Actions\BulkActionGroup::make([
//                    Tables\Actions\DeleteBulkAction::make(),
//                ]),
            ])->recordUrl(function (object $record) {
            return "/objects/" . $record->id;

        });
    }
}
