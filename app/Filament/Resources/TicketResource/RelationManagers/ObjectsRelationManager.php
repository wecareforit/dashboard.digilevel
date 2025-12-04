<?php
namespace App\Filament\Resources\TicketResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class ObjectsRelationManager extends RelationManager
{
    protected static string $relationship = 'objects';
    protected static ?string $title       = 'Objecten';

    protected static bool $isLazy = false;

    public static function getBadge(Model $ownerRecord, string $pageClass): ?string
    {
        // $ownerModel is of actual type Job
        return $ownerRecord
            ->objects
            ->count();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('object_id')
                    ->required()
                    ->label('Kies een object')
                    ->columnSpan('full')
                    ->options(function () {
                        return \App\Models\ObjectsAsset::where('customer_id', $this->getOwnerRecord()->relation_id)
                            ->whereDoesntHave('assetToTickets', function ($query) {
                                $query->where('ticket_id', $this->getOwnerRecord()->id);
                            })
                            ->get()
                            ->groupBy(fn($object) => ucfirst($object->type?->name) ?? 'Onbekend type') // group by type name
                            ->map(function ($group) {
                                return $group->mapWithKeys(function ($object) {
                                    return [
                                        $object->id => trim("{$object?->brand} {$object->model}")
                                        . " " . ($object->serial_number ?? '') . ""
                                        . " " . ($object->employee_name ?? '') . "",
                                    ];
                                });
                            })

                            ->toArray(); // convert to plain array
                    })
                    ->searchable()
                    ->noSearchResultsMessage('Geen objecten gevonden')
                    ->preload(),
            ]);

    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([

                TextColumn::make("object.type.name")
                    ->badge()
                    ->label("Categorie")
                    ->placeholder("-")
                    ->sortable(),

                TextColumn::make("object.brand.name")
                    ->label("Merk")
                    ->placeholder("-")
                    ->sortable(),

                TextColumn::make("object.model.name")
                    ->label("Model")
                    ->placeholder("-")
                    ->sortable(),

                TextColumn::make("object.employee.name")
                    ->badge()
                    ->label("Gebruiker")
                    ->placeholder("-")
                    ->sortable(),

                TextColumn::make("object.serial_number")
                    ->label("Serienummer")
                    ->placeholder("-")
                    ->sortable(),

            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->label('Koppel object')
                    ->icon('heroicon-o-plus')
                    ->link()
                    ->modalHeading('Koppel object aan ticket')
                    ->modalSubheading('Selecteer een object om te koppelen aan dit ticket.')
                    ->modalButton('Koppel object')

                ,

                // Uncomment the following line if you want to use a custom modal view
                // ->modalContent(fn(MountableAction $action) => view('filament.modals.add_object_to_ticket', [
                //     'record' => $this->getOwnerRecord(),
                // ]))

                // ->modalContent(fn(MountableAction $action) => view('filament.modals.add_asset_to_ticket', [
                //     'record' => $this->getOwnerRecord(),
                // ])
                //    ),

                //  Tables\Actions\AttachAction::make(),
            ])
            ->actions([
                //  Tables\Actions\EditAction::make(),
                //    Tables\Actions\DetachAction::make(),

                  Tables\Actions\Action::make('openObject')
                      ->icon('heroicon-m-eye')
                       ->url(fn($record) => "/objects/" . $record?->id),

                Tables\Actions\DeleteAction::make()->label('Ontkoppel')
                    ->icon('heroicon-o-trash')
                    ->modalHeading('Ontkoppel object')
                    ->modalSubheading('Weet u zeker dat u dit object wilt ontkoppelen van dit ticket?')
                    ->modalButton('Ontkoppel object')
                    ->successNotificationTitle('Object ontkoppeld'),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->label('Ontkoppel'),
                ]),
            ])->emptyState(view("partials.empty-state-small"));
    }

    public function hasCombinedRelationManagerTabsWithContent(): bool
    {
        return true;
    }

}
