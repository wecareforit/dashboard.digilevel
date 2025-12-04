<?php
namespace App\Filament\Resources\VehicleResource\Pages;

use App\Filament\Resources\VehicleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\MaxWidth;

class ListVehicles extends ListRecords
{
    protected static string $resource = VehicleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Voertuig toevoegen')

                ->modalWidth(MaxWidth::FourExtraLarge)
                ->modalHeading('Voertuig toevoegen')
                ->modalDescription('Vul een kenteken in om de gegevens op te halen')
                ->modalSubmitActionLabel('Opslaan')
                ->modalIcon('heroicon-o-plus')
                ->icon('heroicon-m-plus')

                ->label('Voertuig toevoegen'),
        ];
    }

    public function getHeading(): string
    {
        return "Voertuig - Overzicht";
    }
}
