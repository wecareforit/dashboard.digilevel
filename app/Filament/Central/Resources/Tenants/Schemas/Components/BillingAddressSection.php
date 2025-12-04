<?php

namespace App\Filament\Central\Resources\Tenants\Schemas\Components;

use App\Filament\Central\Resources\Tenants\Actions\SaveBillingAddressAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;

class BillingAddressSection
{
    public static function make(): Section
    {
        return Section::make('Billing Address')
            ->schema([
                Grid::make(2)
                    ->schema([
                        TextInput::make('line1')
                            ->label('Address Line 1')
                            ->placeholder('123 Laravel Street'),
                        TextInput::make('line2')
                            ->label('Address Line 2')
                            ->placeholder('Apartment B'),
                    ]),
                Grid::make(2)
                    ->schema([
                        TextInput::make('city')
                            ->label('City')
                            ->placeholder('San Francisco'),
                        TextInput::make('postal_code')
                            ->label('Postal code')
                            ->placeholder('12345')
                            ->rule('numeric'),
                    ]),
                Grid::make(2)
                    ->schema([
                        Select::make('country')
                            ->label('Country')
                            ->options(config('saas.countries'))
                            ->placeholder('Select a country'),
                        TextInput::make('state')
                            ->label('State')
                            ->placeholder('California'),
                    ]),

                Actions::make([
                    SaveBillingAddressAction::make(),
                ])->key('billing_address_actions'),
            ])
            ->columnSpanFull();
    }
}
