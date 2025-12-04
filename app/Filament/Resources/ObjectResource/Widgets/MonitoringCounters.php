<?php
namespace App\Filament\Resources\ObjectResource\Widgets;

use Filament\Widgets\Widget;

class MonitoringCounters extends Widget
{
    protected static string $view = 'filament.resources.object-resource.widgets.monitoring-counters';

    protected function getColumns(): int
    {
        return 4;
    }

}
