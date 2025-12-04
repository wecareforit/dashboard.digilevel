<?php
namespace App\Filament\Resources\ElevatorResource\RelationManagers;

use App\Models\ObjectMonitoring;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ObjectMonitoringRelationManager extends RelationManager
{
    protected static string $relationship = 'getMonitoringEvents';
    protected static ?string $title       = "Monitoring events";

    public function form(Form $form): Form
    {
        return $form->schema([]);
        //
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                ObjectMonitoring::whereYear('date_time', date('Y'))
                    ->where('external_object_id', $this->ownerRecord->monitoring_object_id)
                    ->orderBy('date_time', 'desc')
            )
            ->columns([

                TextColumn::make("date_time")
                    ->label("Datum - Tijd")
                    ->date("d-m-Y h:i:s")
                    ->width('100')
                    ->sortable()
                    ->placeholder('-')
                    ->toggleable(),
                // TextColumn::make("error.description")
                //     ->label("Omschrijving")
                //     ->sortable()
                //     ->placeholder('-')
                //     ->getStateUsing(function ($record): ?string {
                //         if ($record?->category == 'error') {
                //             return $record?->error->description;
                //         } else {
                //             return "";
                //         }
                //     })
                //     ->toggleable(),

                TextColumn::make("category")
                    ->label("Categorie")
                    ->badge()
                    ->sortable()
                    ->placeholder('-')
                    ->toggleable(),

                // TextColumn::make("error.posreason")
                //     ->label("Reden")
                //     ->sortable()
                //     ->placeholder('-')
                //     ->toggleable(),

                // TextColumn::make("value")
                //     ->label("Waarde")
                //     ->sortable()
                //     ->placeholder('-')
                //     ->toggleable(),

                TextColumn::make("level")
                    ->label("Verdieping")
                    ->sortable()
                    ->placeholder('-')
                    ->toggleable(),

                TextColumn::make("action")
                    ->label("Actie")
                    ->sortable()
                    ->placeholder('-')
                    ->toggleable(),

            ])

            ->filters([

            ])

            ->emptyState(view('partials.empty-state')
            )
        ;
    }
}
