<?php
namespace App\Filament\Widgets;

use App\Enums\InspectionStatus;
use App\Models\ElevatorInspection;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class InspectionsChart extends ChartWidget
{
    protected static ?string $heading = 'Keuringen 2025';

    protected static ?int $sort                = 1;
    protected int|string|array $columnSpan = '6';
    protected static ?string $maxHeight        = '100%';
    protected static bool $isLazy              = false;
    protected static ?string $pollingInterval  = '10s';
    public function getDescription(): ?string
    {
        return 'Het verloop van de keuringen van het huidige jaar';
    }

    public static function canView(): bool
    {
       return setting('module_elevators') ?? false;
    }


    protected function getData(): array
    {

        $dataRejected = Trend::query(ElevatorInspection::whereYear('executed_datetime', date('Y'))->where('status_id', InspectionStatus::REJECTED))

            ->dateColumn('executed_datetime')
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->count();

        $dataApproved = Trend::query(ElevatorInspection::whereYear('executed_datetime', date('Y'))->where('status_id', InspectionStatus::APPROVED)
        )

            ->dateColumn('executed_datetime')
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->count();

        $dataApprovedActions = Trend::query(ElevatorInspection::whereYear('executed_datetime', date('Y'))->where('status_id', InspectionStatus::APPROVED_ACTIONS)
        )

            ->dateColumn('executed_datetime')
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->count();

        $dataApprovedRepeat = Trend::query(ElevatorInspection::whereYear('executed_datetime', date('Y'))->where('status_id', InspectionStatus::APPROVED_REPEAT)
        )

            ->dateColumn('executed_datetime')
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
                    'data'            => $dataRejected->map(fn(TrendValue $value) => round($value->aggregate)),
                ],

                [
                    'label'           => ' Goedgekeurd',
                    'backgroundColor' => 'rgb(133, 202, 143)',
                    'borderColor'     => 'rgb(133, 202, 143)',
                    'data'            => $dataApproved->map(fn(TrendValue $value) => round($value->aggregate)),
                ],

                [
                    'label'           => 'Goedgekeurd (Herhaal punten)',
                    'backgroundColor' => 'rgb(255,251,235)',
                    'borderColor'     => 'rgb(251,237,212)',
                    'data'            => $dataApprovedActions->map(fn(TrendValue $value) => round($value->aggregate)),
                ],

                [
                    'label'           => 'Goed gekeurd (Met acties)',
                    'backgroundColor' => 'rgb(194, 227, 243)',
                    'borderColor'     => 'rgb(172, 212, 233)',
                    'data'            => $dataApprovedRepeat->map(fn(TrendValue $value) => round($value->aggregate)),
                ],

            ],
            'labels'   => $dataApproved->map(fn(TrendValue $value) => date('m', strtotime($value->date))),

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
                    'precision' => 1,
                ],
            ],

        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
