<?php

namespace App\Filament\Central\Resources\Tenants\Schemas\Components;

use Filament\Forms\Components\TextInput;

class EmailInput
{
    public static function make(): TextInput
    {
        return TextInput::make('email')
            ->label('Email')
            ->placeholder('email@example.com')
            ->email()
            ->required()
            ->maxLength(255)
            ->unique('tenants', 'email');
    }
}
