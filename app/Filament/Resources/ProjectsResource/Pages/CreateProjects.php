<?php

namespace App\Filament\Resources\ProjectsResource\Pages;

use App\Filament\Resources\ProjectsResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateProjects extends CreateRecord
{
    protected static string $resource = ProjectsResource::class;
    protected static ?string $title = 'Project aanmaken';
 

    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }

    public function getRelationManagers(): array
    {
        return [];
    }
    
}