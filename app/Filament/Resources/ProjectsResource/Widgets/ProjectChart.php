<?php

namespace App\Filament\Resources\ProjectsResource\Widgets;

use Filament\Widgets\ChartWidget;

class ProjectChart extends ChartWidget
{
    protected static ?string $heading = 'Chart';

    protected function getData(): array
    {
        return [
            //
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
