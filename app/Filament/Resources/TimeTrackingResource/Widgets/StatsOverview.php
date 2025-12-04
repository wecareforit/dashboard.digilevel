<?php
namespace App\Filament\Resources\TimeTrackingResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total tidd', 1212),
            Stat::make('Aantal registraties', '1'),

        ];
    }
}
