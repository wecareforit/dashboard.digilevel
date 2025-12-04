<?php

namespace App\Filament\Admin\Resources\RelationDepartmentResource\Pages;

use App\Filament\Admin\Resources\RelationDepartmentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRelationDepartments extends ListRecords
{
    protected static string $resource = RelationDepartmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
