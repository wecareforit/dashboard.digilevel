<?php
namespace App\Filament\Resources\SolutionResource\Pages;

use App\Filament\Resources\SolutionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSolutions extends ListRecords
{
    protected static string $resource = SolutionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->modalHeading('Oplossing toevoegen')
                ->modalDescription('Voeg een standaard oplossing toe aan de database')
                ->icon('heroicon-m-plus')
                ->modalIcon('heroicon-o-plus')

                ->label('Oplossing toevoegen'),
        ];
    }
    public function getHeading(): string
    {
        return "Oplossingen - Overzicht";
    }
}
