<?php
namespace App\Filament\Resources\ObjectResource\Widgets;

use App\Models\ObjectMonitoring;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Illuminate\Database\Eloquent\Model;

class MonitoringIncidentChart extends ChartWidget
{
    protected static ?string $heading          = 'Storingen';
    protected int|string|array $columnSpan = '4';
    protected static ?string $maxHeight        = '100%';

    public ?Model $record = null;

    protected static ?string $pollingInterval = '10s';
    protected function getData(): array
    {
        $IncidentData = Trend::query(ObjectMonitoring::where('category', 'error')->whereYear('date_time', date('Y'))
                ->where('external_object_id', $this->record->monitoring_object_id)->whereYear('date_time', date('Y')))
            ->dateColumn('date_time')
            ->between(start: now()->startOfYear(), end: now()->endOfYear())
            ->perMonth()
            ->count();

        return [
            'datasets' => [
                [
                    'label'           => 'Storingen',
                    'backgroundColor' => 'rgb(249, 183, 196)',
                    'borderColor'     => 'rgb(249, 161, 178)',
                    'data'            => $IncidentData->map(fn(TrendValue $value) => round($value->aggregate)),
                ],

            ],
            'labels'   => $IncidentData->map(fn(TrendValue $value) => date('m', strtotime($value->date))),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
    protected static ?array $options = [
        'scale' => [
            'ticks' => [
                'precision' => 0,
            ],
        ],
    ];
    public function getDescription(): ?string
    {
        return 'Deze grafiek toont het storingsverloop gemeld door liftmonitoring';
    }

}
