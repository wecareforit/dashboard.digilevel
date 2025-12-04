<?php

namespace App\Filament\Central\Resources\Tenants\Actions;

use App\BillingManager;
use App\Models\Tenant;
use Filament\Actions\Action;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Notifications\Notification;

class UpdateCreditBalanceAction
{
    public static function make(): Action
    {
        return Action::make('adjust_credit_balance')
            ->label('Update')
            ->color('primary')
            ->disabled(fn (Tenant $record): bool => ! BillingManager::tenantCanUseStripe($record))
            ->action(function (Tenant $record, Get $get, Set $set): void {
                $adjustment = (float) $get('credit_balance_adjustment');

                if ($adjustment == 0) {
                    Notification::make()
                        ->warning()
                        ->title('No adjustment made')
                        ->body('Enter a non-zero value to adjust the credit balance.')
                        ->send();

                    return;
                }

                BillingManager::adjustCredit($record, $adjustment);

                $set('credit_balance_adjustment', null);
                $set('current_balance_display', $record->getCreditBalance(returnFormatted: true));

                Notification::make()
                    ->success()
                    ->title('Credit balance updated')
                    ->send();
            });
    }
}
