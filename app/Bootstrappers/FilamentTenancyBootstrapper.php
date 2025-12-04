<?php

declare(strict_types=1);

namespace App\Bootstrappers;

use Stancl\Tenancy\Contracts\TenancyBootstrapper;
use Stancl\Tenancy\Contracts\Tenant;
use Filament\Panel;
use Filament\Facades\Filament;

class FilamentTenancyBootstrapper implements TenancyBootstrapper
{
    protected Panel|null $centralPanel = null;

    public function bootstrap(Tenant $tenant): void
    {
        $this->centralPanel = Filament::getCurrentPanel();

        Filament::setCurrentPanel(Filament::getPanel('tenant_admin'));
    }

    public function revert(): void
    {
        Filament::setCurrentPanel($this->centralPanel);
    }
}
