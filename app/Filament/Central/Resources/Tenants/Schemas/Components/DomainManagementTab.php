<?php

namespace App\Filament\Central\Resources\Tenants\Schemas\Components;

use App\Filament\Central\Resources\Tenants\RelationManagers\DomainsRelationManager;
use Filament\Schemas\Components\Livewire;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Resources\Pages\EditRecord;

class DomainManagementTab
{
    public static function make(EditRecord $page): Tab
    {
        return Tab::make('Domains')
            ->icon('heroicon-o-globe-alt')
            ->schema(static::schema($page));
    }

    protected static function schema(EditRecord $page): array
    {
        return [
            Livewire::make(DomainsRelationManager::class, [
                'ownerRecord' => $page->record,
                'pageClass' => get_class($page),
            ]),
        ];
    }
}
