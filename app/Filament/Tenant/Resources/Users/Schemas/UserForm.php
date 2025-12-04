<?php

namespace App\Filament\Tenant\Resources\Users\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->unique()
                    ->required(),
                TextInput::make('password')
                    ->password()
                    ->required(),
                TextInput::make('password_confirmation')
                    ->label('Confirm password')
                    ->password()
                    ->required(),
            ]);
    }
}
