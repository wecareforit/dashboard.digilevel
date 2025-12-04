<?php
namespace App\Filament\Resources\ObjectResource\Widgets;

use App\Models\ObjectMonitoring;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Illuminate\Database\Eloquent\Model;

class DirectionChart extends ChartWidget
{
    protected static ?string $heading          = 'Bewegingsrichting';
    protected int|string|array $columnSpan = '4';
    protected static ?string $maxHeight        = '100%';
    public ?Model $record                      = null;

    protected function getData(): array
    {
        // $stopData = Trend::query(ObjectMonitoring::where('category', 'direction')->Where('value', 0)->whereYear('created_at', date('Y'))
        //         ->where('external_object_id', $this->record->monitoring_object_id)->whereYear('created_at', date('Y')))
        //     ->dateColumn('created_at')
        //     ->between(start: now()->startOfYear(), end: now()->endOfYear())
        //     ->perMonth()
        //     ->count();

        $upData = Trend::query(ObjectMonitoring::where('category', 'direction')->WhereIn('value', [4, 5])->whereYear('created_at', date('Y'))
                ->where('external_object_id', $this->record->monitoring_object_id)->whereYear('created_at', date('Y')))
            ->dateColumn('created_at')
            ->between(start: now()->startOfYear(), end: now()->endOfYear())
            ->perMonth()
            ->count();

        $downData = Trend::query(ObjectMonitoring::where('category', 'direction')->WhereIn('value', [2, 3])->whereYear('created_at', date('Y'))
                ->where('external_object_id', $this->record->monitoring_object_id)->whereYear('created_at', date('Y')))
            ->dateColumn('created_at')
            ->between(start: now()->startOfYear(), end: now()->endOfYear())
            ->perMonth()
            ->count();

        return [
            'datasets' => [

                [
                    'label'           => 'Naar boven',
                    'backgroundColor' => 'rgb(194, 227, 243)',
                    'borderColor'     => 'rgb(172, 212, 233)',
                    'data'            => $upData->map(fn(TrendValue $value) => round($value->aggregate)),
                ],
                [
                    'label'           => 'Naar beneden',
                    'backgroundColor' => 'rgb(249, 183, 196)',
                    'borderColor'     => 'rgb(249, 161, 178)',
                    'data'            => $downData->map(fn(TrendValue $value) => round($value->aggregate)),
                ],

            ],
            'labels'   => $upData->map(fn(TrendValue $value) => date('m', strtotime($value->date))),
        ];
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
        return 'Deze grafiek toon het aantal bewegingen omhoog en omlaag.';
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
