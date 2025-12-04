<?php

namespace App\Filament\Central\Resources\Tenants\Schemas;

use App\Filament\Central\Resources\Tenants\Schemas\Components;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class CreateTenantForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Grid::make(1)
                ->schema([
                    Components\DomainInput::make(),Components\NameInput::make(),
                    Components\CompanyInput::make(),
                    Components\EmailInput::make(),
                    Components\PasswordInput::make(),
                    Components\PasswordInput::makeConfirmation(),
                ]),
        ]);
    }
}
