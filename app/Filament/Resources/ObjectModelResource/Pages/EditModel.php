<?php
namespace App\Filament\Resources\ObjectModelResource\Pages;

use App\Filament\Resources\ObjectModelResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditModel extends EditRecord
{
    protected static string $resource = ObjectModelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()->lable('Model toevoegen'),
        ];
    }
}
