<?php

namespace App\Filament\Clusters\General\Resources\RelationTypeResource\Pages;

use App\Filament\Clusters\General\Resources\RelationTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRelationTypes extends ListRecords
{
    protected static string $resource = RelationTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
