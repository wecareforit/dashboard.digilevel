<?php
namespace App\Filament\Resources\RelationResource\RelationManagers;

use App\Models\relationLocation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class DepartmentsRelationManager extends RelationManager
{
    protected static string $relationship = 'departments';
    protected static ?string $title       = 'Afdelingen';

    public static function canViewForRecord(Model $ownerRecord, string $pageClass): bool
    {

        return in_array('Afdelingen', $ownerRecord?->type?->options) ? true : false;
    }

    public static function getBadge(Model $ownerRecord, string $pageClass): ?string
    {
        return $ownerRecord->departments()->count();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                Forms\Components\Select::make('relation_location_id')
                    ->label('Locatie')
                    ->visible(fn() => in_array('Locaties', $this->ownerRecord?->type?->options) ? true : false)

                    ->options(function () {
                        $relationId = $this->ownerRecord?->id;
                        return relationLocation::query()
                            ->when($relationId, fn($query) => $query->where('relation_id', $relationId))
                            ->get()
                            ->mapWithKeys(function ($location) {
                                return [
                                    $location->id => collect([
                                        $location->address,
                                        $location->zipcode,
                                        $location->place,
                                    ])->filter()->implode(', '),
                                ];
                            })
                            ->toArray();
                    }),
            ]);

    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Naam'),
                Tables\Columns\TextColumn::make('location.name')
                    ->label('Locatie')
                    ->visible(fn() => in_array('Locaties', $this->ownerRecord?->type?->options) ? true : false)
                ,

            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->label('Afdeling aanmaken')
                    ->link()
                    ->icon('heroicon-m-plus')
                    ->modalHeading('Locatie toevoegen'),
            ])
            ->actions([

                Tables\Actions\ActionGroup::make([

                    Tables\Actions\EditAction::make()
                        ->label('Wijzigen')

                        ->modalHeading('Locatie wijzigen'),

                    Tables\Actions\DeleteAction::make()
                        ->label('Verwijder'),

                    RestoreAction::make(),
                ]),

                // Tables\Actions\ViewAction::make('openLocation')
                //     ->label('Bekijk')
                //     ->url(function ($record) {
                //         return "/relation-locations/" . $record->id;
                //     })
                //     ->icon('heroicon-s-eye'),
                // Tables\Actions\EditAction::make()
                //     ->label('Wijzigen')
                //
                //     ->modalHeading('Locatie wijzigen'),

                // Tables\Actions\DeleteAction::make()
                //     ->modalHeading('Bevestig actie')
                //     ->modalDescription('Weet je zeker dat je deze Locatie wilt verwijderen?'),

            ])->emptyState(view("partials.empty-state"));
    }
}
