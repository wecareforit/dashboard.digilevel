<?php
namespace App\Filament\Resources\ObjectMonitoringCodesResource\Pages;

use App\Filament\Resources\ObjectMonitoringCodesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\MaxWidth;

class ListObjectMonitoringCodes extends ListRecords
{
    protected static string $resource = ObjectMonitoringCodesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \EightyNine\ExcelImport\ExcelImportAction::make()
                ->label('Importeren')
                ->outlined()
                ->link()
                ->color('primary'),

            Actions\CreateAction::make()
                ->label('Monitoringcode toevoegen')
                ->modalWidth(MaxWidth::FourExtraLarge)
                ->modalHeading('Monitoringcode toevoegen')
                ->modalDescription('Voeg een nieuwe monitoringcode toe door de onderstaande gegevens in te vullen.')
                ->icon('heroicon-m-plus')
                ->modalIcon('heroicon-o-plus')
            ,
        ];
    }

    public function getHeading(): string
    {
        return "Monitoringcodes - Overzicht";
    }
}
