<?php
namespace App\Filament\Resources\VehicleResource\Pages;

use App\Filament\Resources\VehicleResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;

class ViewVehicle extends ViewRecord
{
    protected static string $resource = VehicleResource::class;

    protected function getHeaderActions():
    array {
        return [
            // Action::make('back')

            //     ->label('Terug naar overzicht')
            //     ->link()
            //     ->url('/vehicles')
            //     ->color('gray'),
            Actions\EditAction::make()->icon('heroicon-m-pencil-square')
            ,
            Actions\DeleteAction::make()->icon('heroicon-m-trash'),
        ];
    }

}
