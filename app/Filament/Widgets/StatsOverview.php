<?php
namespace App\Filament\Widgets;

use App\Enums\ElevatorStatus;
use App\Models\Elevator;
use App\Models\ObjectIncident;
use DB;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{

    protected static ?int $sort                = 0;
    protected int|string|array $columnSpan = '12';
    protected static bool $isLazy              = false;

    public static function canView(): bool
    {
       return setting('module_elevators') ?? false;
    }

    protected function getColumns(): int
    {
        return 4;
    }

    protected function getStats(): array
    {

        $incidentChart = ObjectIncident::select(DB::raw('EXTRACT(MONTH FROM report_date_time) as month'), DB::raw('count(*) as total'))
            ->whereYear('report_date_time', '2025')
            ->groupBy(DB::raw('EXTRACT(MONTH FROM report_date_time)'))
            ->pluck('total', 'month')
            ->toArray();

        $incidentStillChart = ObjectIncident::select(DB::raw('EXTRACT(MONTH FROM report_date_time) as month'), DB::raw('count(*) as total'))
            ->whereYear('report_date_time', '2025')
            ->where('standing_still', 1)
            ->groupBy(DB::raw('EXTRACT(MONTH FROM report_date_time)'))
            ->pluck('total', 'month')
            ->toArray();

        // $inspectionApporovedChart = ObjectInspection::select(DB::raw('MONTH(executed_datetime) as month'), DB::raw('count(*) as total'))
        //     ->whereYear('executed_datetime', '2025')
        //     ->where('status_id', InspectionStatus::APPROVED)
        //     ->groupBy(DB::raw('MONTH(executed_datetime)'))
        //     ->pluck('total', 'month')
        //     ->toArray();

        // $inspectionApporovedActionsChart = ObjectInspection::select(DB::raw('MONTH(executed_datetime) as month'), DB::raw('count(*) as total'))
        //     ->whereYear('executed_datetime', '2025')
        //     ->where('status_id', InspectionStatus::APPROVED_ACTIONS)
        //     ->groupBy(DB::raw('MONTH(executed_datetime)'))
        //     ->pluck('total', 'month')
        //     ->toArray();

        // $inspectionRejectedChart = ObjectInspection::select(DB::raw('MONTH(executed_datetime) as month'), DB::raw('count(*) as total'))
        //     ->whereYear('executed_datetime', '2025')
        //     ->where('status_id', InspectionStatus::REJECTED)
        //     ->groupBy(DB::raw('MONTH(executed_datetime)'))
        //     ->pluck('total', 'month')
        //     ->toArray();

        // $inspectionRejected = Trend::query(Elevator::where('current_inspection_status_id', InspectionStatus::REJECTED))

        //     ->dateColumn('current_inspection_end_date')
        //     ->between(
        //         start: now()->startOfYear(),
        //         end: now()->endOfYear(),
        //     )
        //     ->perMonth()
        //     ->count();
        // dd($inspectionRejected);

        return [
            Stat::make('Stilstaande objecten', Elevator::has("incident_stand_still")->latest()->count()),
            //  ->chart($inspectionRejectedChart),
            Stat::make('Storingen', ObjectIncident::count())
                ->color('success')
                ->chart($incidentChart),
            Stat::make('Storingen stilstand', ObjectIncident::where('standing_still', 1)->count())
                ->chart($incidentStillChart)
                ->color('danger'),
            Stat::make('Objecten buitenbedrijf', Elevator::where('status_id', ElevatorStatus::TURNEDOFF)->count())
                ->color('danger'),
            // Stat::make('Goedgekeurd', Elevator::where('current_inspection_status_id', InspectionStatus::APPROVED)->count())
            //     ->chart($inspectionApporovedChart),
            // Stat::make('Goedgekeurd met acties', Elevator::where('current_inspection_status_id', InspectionStatus::APPROVED_ACTIONS)->count())
            //     ->chart($inspectionApporovedActionsChart)
            //     ->color('warning'),
            // Stat::make('Afgekeurd', Elevator::where('current_inspection_status_id', InspectionStatus::REJECTED)->count())
            //     ->chart($inspectionApporovedActionsChart)
            //     ->color('danger'),

        ];
    }
}

//                    {{count($elevators->where('current_inspection_status_id', 3)->where('management_elevator',1)) /$cnt_managment_elevators * 100}}%
