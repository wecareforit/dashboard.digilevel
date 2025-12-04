<?php
namespace App\Filament\Resources\TicketResource\Pages;

use App\Filament\Resources\TicketResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

use Nben\FilamentRecordNav\Concerns\WithRecordNavigation;


class EditTicket extends EditRecord
{
    protected static string $resource = TicketResource::class;
    use WithRecordNavigation;
    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }

}
