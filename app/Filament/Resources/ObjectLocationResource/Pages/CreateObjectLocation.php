<?php

namespace App\Filament\Resources\ObjectLocationResource\Pages;

use App\Filament\Resources\ObjectLocationResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateObjectLocation extends CreateRecord
{
    protected static string $resource = ObjectLocationResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }

}
