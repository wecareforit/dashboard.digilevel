<?php

namespace App\Filament\Central\Resources\Tenants\Schemas\Components;

use Filament\Forms\Components\TextInput;

class NameInput
{
    public static function make(): TextInput
    {
        return TextInput::make('name')
            ->label('Full name')
            ->placeholder('Full name')
            ->required()
            ->maxLength(255);
    }
}
