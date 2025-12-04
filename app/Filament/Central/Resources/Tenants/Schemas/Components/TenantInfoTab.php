<?php

namespace App\Filament\Central\Resources\Tenants\Schemas\Components;

use App\Filament\Central\Resources\Tenants\Actions\SaveTenantInfoAction;
use Carbon\Carbon;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs\Tab;

class TenantInfoTab
{
    public static function make(): Tab
    {
        return Tab::make('Info')
            ->icon('heroicon-o-information-circle')
            ->schema(static::schema());
    }

    protected static function schema(): array
    {
        return [
            Grid::make(1)
                ->schema([
                    TextInput::make('id')
                        ->label('Tenant ID')
                        ->disabled()
                        ->dehydrated(false),
                    TextInput::make('email')
                        ->label('Email')
                        ->email()
                        ->dehydrated(false),
                    TextInput::make('company')
                        ->label('Company')
                        ->dehydrated(false),
                    TextInput::make('created_at')
                        ->label('Created at')
                        ->formatStateUsing(fn (string $state): string => Carbon::parse($state)->format('d M Y'))
                        ->disabled()
                        ->dehydrated(false),
                    TextInput::make('updated_at')
                        ->label('Updated at')
                        ->formatStateUsing(fn (string $state): string => Carbon::parse($state)->format('d M Y'))
                        ->disabled()
                        ->dehydrated(false),
                ]),

            Actions::make([
                SaveTenantInfoAction::make(),
            ])->key('tenant_info_actions'),
        ];
    }
}
