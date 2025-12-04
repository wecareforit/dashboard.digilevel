<?php
namespace App\Filament\Pages;

use App\Filament\Widgets\LastIncidents; 
use App\Filament\Widgets\Tasks;


class Dashboard extends \Filament\Pages\Dashboard
{
    public function getColumns(): int | string | array
    {

        return 12;
    }

    public function getHeaderWidgets(): array
    {

        $widgets = [];

       //   $widgets[] =    Tasks::class;

        // if (setting('use_incidents')) {
        //     $widgets[] = LastIncidents::class;
        //     //   $widgets[] = IncidentChart::class;
        //     //   $widgets[] = LastIncidents::class;
        // }

        // if (setting('use_api_connection')) {
        //     $widgets[] = TasksOverview::class;
        // }

        // if (setting('use_api_connection')) {
        //     $widgets[] = TasksOverview::class;
        // }




        return $widgets;

    }

}


 