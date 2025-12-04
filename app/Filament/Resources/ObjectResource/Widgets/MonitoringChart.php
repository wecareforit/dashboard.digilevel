<?php
namespace App\Filament\Resources\ObjectResource\Widgets;

use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class MonitoringChart extends ChartWidget
{
    protected static ?string $heading          = 'Chart';
    protected int|string|array $columnSpan = '7';
    protected static ?string $maxHeight        = '100%';
    public ?Model $record                      = null;

    protected function getData(): array
    {

        $data = Trend::where('external_object_id', $this->record->monitoring_object_id)->whereYear('created_at', date('Y'))

            ->dateColumn('created_at')
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->count();

        return [
            'datasets' => [

                [
                    'label'           => 'Afgekeurd',
                    'backgroundColor' => 'rgb(249, 183, 196)',
                    'borderColor'     => 'rgb(249, 161, 178)',
                    'data'            => $data->map(fn(TrendValue $value) => round($value->aggregate)),
                ],

            ],
            'labels'   => $data->map(fn(TrendValue $value) => date('m', strtotime($value->date))),

        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
