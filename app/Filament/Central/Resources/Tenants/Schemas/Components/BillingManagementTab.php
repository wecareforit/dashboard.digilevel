<?php

namespace App\Filament\Central\Resources\Tenants\Schemas\Components;

use App\BillingManager;
use App\Models\Tenant;
use Filament\Schemas\Components\View;
use Filament\Schemas\Components\Tabs\Tab;

class BillingManagementTab
{
    public static function make(): Tab
    {
        return Tab::make('Billing')
            ->icon('heroicon-o-credit-card')
            ->schema(static::schema());
    }

    protected static function schema(): array
    {
        return [
            View::make('components.subscription-banner')
                ->viewData(fn (Tenant $record) => BillingManager::getSubscriptionBannerProps($record)),
            BillingAddressSection::make(),
            CreditBalanceSection::make(),
        ];
    }
}
