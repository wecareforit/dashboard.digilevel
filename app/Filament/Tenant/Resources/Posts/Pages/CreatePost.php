<?php

namespace App\Filament\Tenant\Resources\Posts\Pages;

use App\Filament\Tenant\Resources\Posts\PostResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePost extends CreateRecord
{
    protected static string $resource = PostResource::class;
}
