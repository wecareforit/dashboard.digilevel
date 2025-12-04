<?php
namespace App\Filament\Resources\ContactResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;

class ProjectsRelationManager extends RelationManager
{
    protected static string $relationship = 'projects';
    protected static ?string $title       = 'Gekoppelde projecten';
    protected static ?string $subheading  = 'Custom Page Heading';
    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make("id")
                    ->label("#")
                    ->getStateUsing(function ($record): ?string {
                        return sprintf("%05d", $record?->id);
                    })
                    ->sortable()
                    ->wrap()
                ,

                Tables\Columns\TextColumn::make("name")
                    ->label("Omschrijving")
                    ->wrap()
                    ->description(function ($record) {
                        if (! $record?->description) {
                            return false;
                        } else {
                            return $record->description;
                        }
                    })

                ,

                Tables\Columns\TextColumn::make("customer.name")
                    ->label("Relatie")
                    ->placeholder('-')
                    ->url(function ($record) {
                        return "/relations/" . $record->customer_id;
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make("location")
                    ->getStateUsing(function ($record): ?string {
                        return $record?->location?->address . "-" . $record?->location?->zipcode . " - " . $record?->location?->place;
                    })
                    ->label("Locatie")
                    ->placeholder('Geen')
                    ->url(function ($record) {
                        return "/relation-locations/" . $record->location_id;
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make("status.name")
                    ->label("Status")
                    ->placeholder('Onbekend')
                    ->sortable()
                    ->badge(),

            ])
            ->filters([
                //
            ])
            ->headerActions([
                //  Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Action::make('openproject')
                    ->label('Meer informatie')
                    ->url(function ($record) {
                        return "/projects/" . $record->model_id;
                    })->icon('heroicon-s-eye'),

            ])->emptyState(view("partials.empty-state"));

    }

}
