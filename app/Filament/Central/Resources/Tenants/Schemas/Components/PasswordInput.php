<?php

namespace App\Filament\Central\Resources\Tenants\Schemas\Components;

use Filament\Forms\Components\TextInput;

class PasswordInput
{
    public static function make(): TextInput
    {
        return TextInput::make('password')
            ->label('Password')
            ->placeholder('Password')
            ->password()
            ->required()
            ->maxLength(255)
            ->confirmed();
    }

    public static function makeConfirmation(): TextInput
    {
        return TextInput::make('password_confirmation')
            ->label('Confirm password')
            ->placeholder('Confirm password')
            ->password()
            ->same('password')
            ->required()
            ->dehydrated(false);
    }
}
