<?php
namespace App\Filament\Resources\ErrorResource\Pages;

use App\Filament\Resources\ErrorResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListErrors extends ListRecords
{
    protected static string $resource = ErrorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->modalHeading('Foutmelding toevoegen')
                ->modalDescription('Voeg een standaard foutmelding toe aan de database')
                ->icon('heroicon-m-plus')
                ->modalIcon('heroicon-o-plus')

                ->label('Foutmelding toevoegen'),
        ];
    }
    public function getHeading(): string
    {
        return "Foutmeldingen - Overzicht";
    }
}
