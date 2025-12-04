<?php
namespace App\Filament\Resources\ObjectResource\Widgets;

use App\Models\ObjectMonitoring;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Model;

class FloorTable extends BaseWidget
{
    public ?Model $record = null;
    public function table(Table $table): Table
    {

        //     $stopData = Trend::query(->whereYear('created_at', date('Y'))
        //     ->where('external_object_id', $this->record->monitoring_object_id)->whereYear('created_at', date('Y')))
        // ->dateColumn('created_at')
        // ->between(start: now()->startOfYear(), end: now()->endOfYear())
        // ->perMonth()
        // ->count();

        return $table
            ->query(ObjectMonitoring::where('category', 'stop')
                    ->where('external_object_id', $this->record->monitoring_object_id)
                    ->orderBy('value', 'asc')
            )
            ->columns([
                Tables\Columns\TextColumn::make('value')
                    ->label('value')
                ,

                Tables\Columns\TextColumn::make('stops_count')
                    ->counts("stops")
                    ->label('Stops'),
            ]);
    }
}
