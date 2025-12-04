<?php

namespace App\Filament\Resources\VehicleGPSResource\Pages;

use App\Filament\Resources\VehicleGPSResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditVehicleGPS extends EditRecord
{
    protected static string $resource = VehicleGPSResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
