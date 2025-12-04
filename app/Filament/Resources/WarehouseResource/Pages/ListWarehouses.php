<?php
namespace App\Filament\Resources\WarehouseResource\Pages;

use App\Filament\Resources\WarehouseResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\MaxWidth;

class ListWarehouses extends ListRecords
{
    protected static string $resource = WarehouseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Magazijn toevoegen')

                ->modalWidth(MaxWidth::FourExtraLarge)
                ->modalHeading('Magazijn toevoegen')
                ->modalDescription('Vul het magazijn in om de gegevens op te halen')
                ->modalSubmitActionLabel('Opslaan')
                ->modalIcon('heroicon-o-plus')
                ->icon('heroicon-m-plus')

                ->label('Magazijn toevoegen'),
        ];
    }
    public function getHeading(): string
    {
        return "Magazijn - Overzicht";
    }
}
