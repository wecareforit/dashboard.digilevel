<?php

namespace App\Filament\Central\Resources\Tenants\Schemas\Components;

use Filament\Forms\Components\TextInput;

class DomainInput
{
    public static function make(): TextInput
    {
        return TextInput::make('domain')
            ->label('Domain')
            ->placeholder('subdomain')
            ->suffix('.' . config('tenancy.identification.central_domains')[0])
            ->required()
            ->regex('/^[A-Za-z0-9-]+$/')
            ->unique('domains', 'domain');
    }
}
