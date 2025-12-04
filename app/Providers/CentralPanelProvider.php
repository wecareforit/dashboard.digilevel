<?php
namespace App\Providers;

use App\Filament\Resources\TenantResource;
use Filament\Panel;
use Filament\PanelProvider;

class CentralPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('central')
            ->path('admin') // Central panel at app.local/admin
            ->resources([
                TenantResource::class, // Manage tenants
            ])
            ->middleware([
                'web',
                \Filament\Http\Middleware\Authenticate::class,
            ]);
    }
}
