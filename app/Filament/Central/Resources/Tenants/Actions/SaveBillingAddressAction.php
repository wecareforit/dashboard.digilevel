<?php

namespace App\Filament\Central\Resources\Tenants\Actions;

use App\BillingManager;
use App\Models\Tenant;
use Filament\Actions\Action;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Notifications\Notification;
use Illuminate\Support\Arr;

class SaveBillingAddressAction
{
    public static function make(): Action
    {
        return Action::make('save_billing_address')
            ->label('Save')
            ->color('primary')
            ->disabled(fn (Tenant $record): bool => ! BillingManager::tenantCanUseStripe($record))
            ->action(function (Tenant $record, Get $get): void {
                // Get only the billing address fields we need from the form state
                $data = Arr::only($get(), array_keys(BillingManager::billingAddressValidationRules()));

                BillingManager::updateAddress($record, $data);

                Notification::make()
                    ->success()
                    ->title('Billing address updated')
                    ->send();
            });
    }
}
