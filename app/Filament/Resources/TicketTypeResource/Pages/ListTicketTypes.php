<?php
namespace App\Filament\Resources\TicketTypeResource\Pages;

use App\Filament\Resources\TicketTypeResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\MaxWidth;

class ListTicketTypes extends ListRecords
{
    protected static string $resource = TicketTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->label('Terug naar overzicht')
                ->link()
                ->url(url()->previous())
                ->color('gray'),

            Actions\CreateAction::make()
                ->label('Toevoegen')
                ->modalWidth(MaxWidth::ExtraLarge)
                ->icon('heroicon-o-plus')
                ->modalHeading('Ticket type toevoegen'),

        ];
    }

    public function getHeading(): string
    {
        return "Ticket Categorieën  - Overzicht";
    }
}
