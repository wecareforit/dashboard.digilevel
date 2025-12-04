<?php
namespace App\Filament\Resources\ObjectResource\Widgets;

use App\Models\ObjectMonitoring;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Illuminate\Database\Eloquent\Model;

class MonitoringStopsenDoors extends ChartWidget
{
    protected static ?string $heading          = 'Deuropeningen en stops';
    protected int|string|array $columnSpan = '4';
    protected static ?string $maxHeight        = '100%';

    public ?Model $record = null;

    protected static ?string $pollingInterval = '10s';
    protected function getData(): array
    {
        $stopData = Trend::query(ObjectMonitoring::where('category', 'stop')->whereYear('date_time', date('Y'))
                ->where('external_object_id', $this->record->monitoring_object_id)->whereYear('date_time', date('Y')))
            ->dateColumn('date_time')
            ->between(start: now()->startOfYear(), end: now()->endOfYear())
            ->perMonth()
            ->count();

        $openData = Trend::query(ObjectMonitoring::where('category', 'doors')->whereIn('value', [0, 2])->whereYear('date_time', date('Y'))
                ->where('external_object_id', $this->record->monitoring_object_id)->whereYear('date_time', date('Y')))
            ->dateColumn('date_time')
            ->between(start: now()->startOfYear(), end: now()->endOfYear())
            ->perMonth()
            ->count();

        $closeData = Trend::query(ObjectMonitoring::where('category', 'doors')->whereIn('value', [1, 3])->whereYear('date_time', date('Y'))
                ->where('external_object_id', $this->record->monitoring_object_id)->whereYear('date_time', date('Y')))
            ->dateColumn('date_time')
            ->between(start: now()->startOfYear(), end: now()->endOfYear())
            ->perMonth()
            ->count();

        return [
            'datasets' => [
                [
                    'label'           => 'Stops',
                    'backgroundColor' => 'rgb(194, 227, 243)',
                    'borderColor'     => 'rgb(172, 212, 233)',
                    'data'            => $stopData->map(fn(TrendValue $value) => round($value->aggregate)),
                ],
                [
                    'label'           => 'Geopend',
                    'backgroundColor' => 'rgb(249, 183, 196)',
                    'borderColor'     => 'rgb(249, 161, 178)',

                    'data'            => $openData->map(fn(TrendValue $value) => round($value->aggregate)),
                ],
                [
                    'label'           => 'Gesloten',
                    'backgroundColor' => 'rgb(133, 202, 143)',
                    'borderColor'     => 'rgb(133, 202, 143)',

                    'data'            => $closeData->map(fn(TrendValue $value) => round($value->aggregate)),
                ],

            ],
            'labels'   => $stopData->map(fn(TrendValue $value) => date('m', strtotime($value->date))),
        ];
    }

    protected static ?array $options = [
        'scale' => [
            'ticks' => [
                'precision' => 0,
            ],
        ],
    ];

    protected function getType(): string
    {
        return 'bar';
    }

    public function getDescription(): ?string
    {
        return 'Deze grafiek toont het aantal deur openeningen en stops';
    }

}
