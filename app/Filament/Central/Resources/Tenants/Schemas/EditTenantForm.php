<?php

namespace App\Filament\Central\Resources\Tenants\Schemas;

use App\Filament\Central\Resources\Tenants\Schemas\Components;
use Filament\Schemas\Components\Tabs;
use Filament\Resources\Pages\EditRecord;
use Filament\Schemas\Schema;

class EditTenantForm
{
    public static function configure(Schema $schema, EditRecord $page): Schema
    {
        return $schema->components([
            Tabs::make('Tabs')
                ->tabs([
                    Components\TenantInfoTab::make(),
                    Components\BillingManagementTab::make(),
                    Components\DomainManagementTab::make($page),
                ])
                ->persistTabInQueryString()
                ->columnSpanFull(),
        ]);
    }
}
