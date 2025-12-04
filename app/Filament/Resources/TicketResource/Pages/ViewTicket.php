<?php
namespace App\Filament\Resources\TicketResource\Pages;

use App\Filament\Resources\TicketResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;
use Filament\Tables\Actions\ActionGroup;
use Livewire\Attributes\On;

use Nben\FilamentRecordNav\Concerns\WithRecordNavigation;
 use Nben\FilamentRecordNav\Actions\NextRecordAction;
use Nben\FilamentRecordNav\Actions\PreviousRecordAction;
 
 


class ViewTicket extends ViewRecord
{

 
 use WithRecordNavigation;
 
    #[On('refreshForm')]
    public function refreshForm(): void
    {
        $this->fillForm();
    }

    public function getTitle(): string
    {
        return 'Bekijk ticket: #' . $this->record->id;
    }

    // public function getHeader(): string
    // {
    //     return 'Bekijk ticket: #' . $this->record->id;
    // }

    protected static string $resource = TicketResource::class;

    protected $listeners = ["refresh" => '$refresh'];

    protected function getHeaderActions():
    array {
        return [
            Action::make('back')
                ->label('Terug naar overzicht')
                ->link()
                ->url(url()->previous())
                ->color('gray'),

            Actions\EditAction::make()
                ->slideOver()

                ->icon('heroicon-m-pencil-square'),

            ActionGroup::make([
                Actions\DeleteAction::make('Verwijderen'),
            ]),

             
            // PreviousRecordAction::make(),
            // NextRecordAction::make(),
 


        ];
    }

}
