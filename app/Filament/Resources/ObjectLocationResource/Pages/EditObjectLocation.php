<?php

namespace App\Filament\Resources\ObjectLocationResource\Pages;

use App\Filament\Resources\ObjectLocationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Actions\Action;
class EditObjectLocation extends EditRecord
{
    protected static string $resource = ObjectLocationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
            ->link()
       
            ->icon('heroicon-o-trash'),
     

    
                Actions\Action::make('cancel_top')
            ->link()
            ->label('Afbreken')
            ->icon('heroicon-o-arrow-uturn-left')
            ->url($this->getResource()::getUrl('index'))
            ->outlined(),

            
    

            
        Actions\Action::make('save_top')
            ->action('save')
            ->label('Gegevens opslaan'),


        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }

    protected function getFormActions(): array
    {
        return []; // necessary to remove the bottom actions
    }
}
