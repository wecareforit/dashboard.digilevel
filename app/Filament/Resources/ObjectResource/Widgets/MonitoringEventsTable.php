<?php
namespace App\Filament\Resources\ObjectResource\Widgets;

use App\Models\ObjectMonitoring;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Model;

class MonitoringEventsTable extends BaseWidget
{
    protected int|string|array $columnSpan = '8';
    public ?Model $record                      = null;
    protected static ?string $heading          = "Alle meldingen";
    public function table(Table $table): Table
    {
        return $table
            ->query(
                ObjectMonitoring::whereYear('date_time', date('Y'))
                    ->where('external_object_id', $this->record->monitoring_object_id)
                    ->where('category', '<>', 'floor')
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
                SelectFilter::make('category')
                    ->label('Type')
                    ->multiple()
                    ->options(ObjectMonitoring::where('external_object_id', $this->record->monitoring_object_id)->where('category', '<>', 'floor')->pluck('category', 'category')),

                // SelectFilter::make('action')
                //     ->label('Actie')
                //     ->options(ObjectMonitoring::where('external_object_id', $this->record->monitoring_object_id)->pluck('action', 'action')),

                SelectFilter::make('level')
                    ->label('Verdieping')
                    ->options([
                        '1'  => 1,
                        '2'  => 2,
                        '3'  => 3,
                        '4'  => 4,
                        '5'  => 5,
                        '6'  => 6,
                        '7'  => 7,
                        '8'  => 7,
                        '9'  => 9,
                        '10' => 10,
                        '11' => 11,

                    ]),

            ], layout: FiltersLayout::AboveContent)

            ->emptyState(view('partials.empty-state')
            )
        ;
    }

}
