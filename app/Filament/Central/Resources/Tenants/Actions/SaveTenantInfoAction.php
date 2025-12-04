<?php

namespace App\Filament\Central\Resources\Tenants\Actions;

use App\Models\Tenant;
use Filament\Actions\Action;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Notifications\Notification;

class SaveTenantInfoAction
{
    public static function make(): Action
    {
        return Action::make('save_info')
            ->label('Save')
            ->color('primary')
            ->action(function (Tenant $record, Get $get): void {
                $record->update([
                    'company' => $get('company'),
                    'email' => $get('email'),
                ]);

                Notification::make()
                    ->success()
                    ->title('Tenant information updated')
                    ->send();
            });
    }
}
