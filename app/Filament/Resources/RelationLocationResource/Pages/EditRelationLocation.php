<?php

namespace App\Filament\Resources\RelationLocationResource\Pages;

use App\Filament\Resources\RelationLocationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRelationLocation extends EditRecord
{
    protected static string $resource = RelationLocationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
