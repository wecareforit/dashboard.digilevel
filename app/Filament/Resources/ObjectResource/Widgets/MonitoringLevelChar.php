<?php
namespace App\Filament\Resources\ObjectResource\Widgets;

use App\Models\ObjectMonitoring;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Illuminate\Database\Eloquent\Model;

class MonitoringLevelChar extends ChartWidget
{
    protected static ?string $heading          = '';
    protected int|string|array $columnSpan = 'full';
    protected static ?string $maxHeight        = '100%';

    public ?Model $record = null;

    protected static ?string $pollingInterval = '10s';
    protected function getData(): array
    {
        $data0 = Trend::query(ObjectMonitoring::where('category', 'state')
                ->where('value', 0)
                ->whereYear('date_time', date('Y'))
                ->where('external_object_id', $this->record->monitoring_object_id)
        )
            ->dateColumn('date_time')
            ->between(start: now()->startOfYear(), end: now()->endOfYear())
            ->perMonth()
            ->count('value');

        $data1 = Trend::query(ObjectMonitoring::where('category', 'state')
                ->where('value', 1)
                ->whereYear('date_time', date('Y'))
                ->where('external_object_id', $this->record->monitoring_object_id)
        )
            ->dateColumn('date_time')
            ->between(start: now()->startOfYear(), end: now()->endOfYear())
            ->perMonth()
            ->count();

        $data2 = Trend::query(ObjectMonitoring::where('category', 'state')
                ->where('value', 2)
                ->whereYear('date_time', date('Y'))
                ->where('external_object_id', $this->record->monitoring_object_id)
        )
            ->dateColumn('date_time')
            ->between(start: now()->startOfYear(), end: now()->endOfYear())
            ->perMonth()
            ->count();

        $data3 = Trend::query(ObjectMonitoring::where('category', 'state')
                ->where('value', 3)
                ->whereYear('date_time', date('Y'))
                ->where('external_object_id', $this->record->monitoring_object_id)
        )
            ->dateColumn('date_time')
            ->between(start: now()->startOfYear(), end: now()->endOfYear())
            ->perMonth()
            ->count();

        return [
            'datasets' => [
                [
                    'label'           => 'In bedrijf',
                    'backgroundColor' => 'rgb(194, 227, 243)',
                    'borderColor'     => 'rgb(172, 212, 233)',
                    'data'            => $data0->map(fn(TrendValue $value) => round($value->aggregate)),
                ],

                [
                    'label'           => 'Keuring',
                    'backgroundColor' => 'rgb(196, 53, 136)',
                    'borderColor'     => 'rgb(196, 53, 136)',
                    'data'            => $data1->map(fn(TrendValue $value) => round($value->aggregate)),
                ],

                [
                    'label'           => 'Noodgeval',
                    'backgroundColor' => 'rgb(216, 179, 179)',
                    'borderColor'     => 'rgb(216, 179, 179)',
                    'data'            => $data2->map(fn(TrendValue $value) => round($value->aggregate)),
                ],

                [
                    'label'           => 'Foutmelding',
                    'backgroundColor' => 'rgb(214, 243, 194)',
                    'borderColor'     => 'rgb(214, 243, 194)',
                    'data'            => $data3->map(fn(TrendValue $value) => round($value->aggregate)),
                ],

            ],

            'labels'   => $data0->map(fn(TrendValue $value) => date('m', strtotime($value->date))),
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
