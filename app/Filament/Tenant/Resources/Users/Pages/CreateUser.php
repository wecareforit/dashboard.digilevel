<?php

declare(strict_types=1);

namespace App\Filament\Tenant\Resources\Users\Pages;

use App\Filament\Tenant\Resources\Users\UserResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function handleRecordCreation(array $data): Model
    {
       $user = app(CreatesNewUsers::class)->create($data);

       $user->markEmailAsVerified();

       return $user;
    }
}
