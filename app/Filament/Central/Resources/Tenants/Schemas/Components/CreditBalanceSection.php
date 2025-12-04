<?php

namespace App\Filament\Central\Resources\Tenants\Schemas\Components;

use App\BillingManager;
use App\Filament\Central\Resources\Tenants\Actions\UpdateCreditBalanceAction;
use App\Models\Tenant;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;

class CreditBalanceSection
{
    public static function make(): Section
    {
        return Section::make('Credit Balance')
            ->description('Adjust tenant\'s credit balance.')
            ->schema([
                Grid::make(2)
                    ->schema([
                        TextInput::make('credit_balance_adjustment')
                            ->label('Adjust credit balance (+ or -)')
                            ->placeholder('0')
                            ->numeric()
                            ->step(0.01)
                            ->default(0)
                            ->disabled(fn (Tenant $record): bool => ! BillingManager::tenantCanUseStripe($record))
                            ->suffix(fn (Tenant $record): string => $record->getCreditBalance(returnFormatted: false, uppercaseCurrency: true)['currency'])
                            ->dehydrated(false),
                        TextInput::make('current_balance_display')
                            ->label('Current balance')
                            ->disabled()
                            ->formatStateUsing(fn ($state, Tenant $record): string => $record->getCreditBalance(returnFormatted: true))
                            ->dehydrated(false),
                    ]),

                Actions::make([
                    UpdateCreditBalanceAction::make(),
                ])->key('credit_balance_actions'),
            ])
            ->columnSpanFull();
    }
}
