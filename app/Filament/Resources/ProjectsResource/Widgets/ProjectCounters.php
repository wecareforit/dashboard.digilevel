<?php

namespace App\Filament\Resources\ProjectsResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ProjectCounters extends BaseWidget
{

    protected static bool $isLazy = false;
    public ?Project $record = null;

    protected function getStats(): array
    {
  
            return [
                Stat::make('asd', $record),
                Stat::make('Bounce rate', '21%'),
                Stat::make('Average time on page', '3:12'),
                Stat::make('Average time on page', '3:12'),
        ];
    }
}


 
