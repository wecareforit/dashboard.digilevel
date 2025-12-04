<?php
namespace App\Filament\Resources\ObjectModelResource\Pages;

use App\Filament\Resources\ObjectModelResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListModels extends ListRecords
{
    protected static string $resource = ObjectModelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Model toevoegen')
                ->modalHeading('Nieuwe model toevoegen')
                ->modalDescription('Voer hieronder de gegevens om een object model toe te voegen'),
        ];
    }
}
