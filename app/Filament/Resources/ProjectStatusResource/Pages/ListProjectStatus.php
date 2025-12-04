<?php
namespace App\Filament\Resources\ProjectStatusResource\Pages;

use App\Filament\Resources\ProjectStatusResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\MaxWidth;

class ListProjectStatus extends ListRecords
{
    protected static string $resource = ProjectStatusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->label('Terug naar instellingen')
                ->link()
                ->url(url()->previous())
                ->color('gray'),

            Actions\CreateAction::make()
                ->label('Toevoegen')
                ->modalWidth(MaxWidth::ExtraLarge)
                ->modalHeading('Project status  toevoegen'),

        ];
    }

    public function getHeading(): string
    {
        return "Project Statuses - Overzicht";
    }

}
