<?php
namespace App\Filament\Widgets;

use App\Models\ObjectIncident;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class IncidentChart extends ChartWidget
{
    protected static ?string $heading = 'Storingen';

    protected static ?int $sort                = 2;
    protected int|string|array $columnSpan = '6';

    protected static bool $isLazy       = false;
    protected static ?string $maxHeight = '245px';

    protected function getData(): array
    {

        $data = Trend::query(ObjectIncident::whereYear('report_date_time', date('Y')))

            ->dateColumn('report_date_time')
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->count();

        // $data_2024 =

        //     ->dateColumn('report_date_time')
        //     ->between(
        //         start: now()->startOfYear(),
        //         end: now()->endOfYear(),
        //     )
        //     ->perMonth()
        //     ->count();

        // $dataApprovedRepeat = Trend::query(ObjectInspection::where('status_id', InspectionStatus::APPROVED_REPEAT)
        // )

        //     ->dateColumn('end_date')
        //     ->between(
        //         start: now()->startOfYear(),
        //         end: now()->endOfYear(),
        //     )
        //     ->perMonth()
        //     ->count();

        return [
            'datasets' => [

                [
                    'label'           => 'Opgelost',
                    'backgroundColor' => '#7DC481',
                    'borderColor'     => '#7DC481',
                    'data'            => $data->map(fn(TrendValue $value) => round($value->aggregate)),
                ],

            ],
            'labels'   => $data->map(fn(TrendValue $value) => date('m', strtotime($value->date))),

        ];
    }

    // protected function getFilters(): ?array
    // {
    //     return [
    //         'today' => 'Today',
    //         'week'  => 'Last week',
    //         'month' => 'Last month',
    //         'year'  => 'This year',
    //     ];
    // }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => true,
                ],
            ],
            'scale'   => [

                'ticks' => [
                    'precision' => 0,
                ],
            ],

        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
