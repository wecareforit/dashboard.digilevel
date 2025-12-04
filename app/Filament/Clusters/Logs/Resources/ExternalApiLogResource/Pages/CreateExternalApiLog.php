<?php

namespace App\Filament\Clusters\Logs\Resources\ExternalApiLogResource\Pages;

use App\Filament\Clusters\Logs\Resources\ExternalApiLogResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateExternalApiLog extends CreateRecord
{
    protected static string $resource = ExternalApiLogResource::class;
}
