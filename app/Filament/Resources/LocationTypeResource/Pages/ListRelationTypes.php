<?php
namespace App\Filament\Resources\LocationTypeResource\Pages;

use App\Filament\Resources\LocationTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\MaxWidth;

class ListRelationTypes extends ListRecords
{
    protected static string $resource = LocationTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Relatie Type toevoegen')

                ->modalWidth(MaxWidth::FourExtraLarge)
                ->modalHeading('Toevoegen')
                ->modalDescription('Voeg een nieuw relatie type toe door de onderstaande gegeven zo volledig mogelijk in te vullen.')
                ->modalSubmitActionLabel('Opslaan')
                ->modalIcon('heroicon-o-plus')
                ->icon('heroicon-m-plus')

                ->label('Toevoegen'),
        ];
    }

    public function getHeading(): string
    {
        return "Locatie Types - Overzicht";
    }
}
