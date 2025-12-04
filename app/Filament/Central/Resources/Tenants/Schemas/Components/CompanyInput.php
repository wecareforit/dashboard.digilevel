<?php

namespace App\Filament\Central\Resources\Tenants\Schemas\Components;

use Filament\Forms\Components\TextInput;

class CompanyInput
{
    public static function make(): TextInput
    {
        return TextInput::make('company')
            ->label('Company')
            ->placeholder('Company')
            ->required()
            ->maxLength(255);
    }
}
