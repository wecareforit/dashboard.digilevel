<?php
namespace App\Filament\Resources\VehicleGPSResource\Pages;

use App\Filament\Resources\VehicleGPSResource;
use Filament\Resources\Pages\ListRecords;

class ListVehicleGPS extends ListRecords
{
    protected static string $resource = VehicleGPSResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make()
            //     ->label('GPS Module toevoegen')
            //
            //     ->modalWidth(MaxWidth::FourExtraLarge)
            //     ->modalHeading('GPS Module toevoegen')
            //     ->modalSubmitActionLabel('Opslaan')
            //     ->modalIcon('heroicon-o-plus')
            //     ->icon('heroicon-m-plus')
            //
            //     ->label('GPS Module toevoegen'),

        ];
    }
}
