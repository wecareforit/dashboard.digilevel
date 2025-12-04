<?php

namespace App\Filament\Central\Resources\Tenants\Actions;

use App\Models\Tenant;
use Filament\Actions\Action;

class ImpersonateTenantAction
{
    public static function make(): Action
    {
        return Action::make('impersonate')
            ->label('Impersonate')
            ->icon('heroicon-o-user-circle')
            ->action(fn (Tenant $record) => redirect($record->impersonationUrl($record->getAdmin()->id)));
    }
}
