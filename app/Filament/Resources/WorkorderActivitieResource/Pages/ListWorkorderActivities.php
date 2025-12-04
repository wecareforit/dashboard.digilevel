<?php
namespace App\Filament\Resources\WorkorderActivitieResource\Pages;

use App\Filament\Resources\WorkorderActivitieResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\MaxWidth;

class ListWorkorderActivities extends ListRecords
{
    protected static string $resource = WorkorderActivitieResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Uurtype toevoegen')
                ->modalWidth(MaxWidth::FourExtraLarge)
                ->modalHeading('Uurtype toevoegen')
                ->modalDescription('Voeg een nieuw uurtype toe door de onderstaande gegevens in te vullen.')
                ->icon('heroicon-m-plus')
                ->modalIcon('heroicon-o-clock')
            ,
        ];
    }

    public function getHeading(): string
    {
        return "Uurtypen - Overzicht";
    }
}
