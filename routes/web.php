<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Central as Controllers;
use App\Http\Controllers\Admin;
use App\Filament\Central\Resources\Tenants\TenantResource;

foreach (config('tenancy.identification.central_domains') as $domain) {
    Route::domain($domain)->group(function () {

        // Redirect root URL to Filament panel
        Route::get('/', fn() => redirect(config('filament.path', '/admin')))->name('home');

        // Tenant registration and login
        Route::name('central.')->group(function () {
            Route::get('/register', [Controllers\RegisterTenantController::class, 'show'])->name('register');
            Route::post('/register/submit', [Controllers\RegisterTenantController::class, 'submit'])
                ->name('register.submit')
                ->middleware('throttle:create-tenant');

            Route::get('/login', [Controllers\LoginTenantController::class, 'show'])->name('login');
            Route::post('/login/submit', [Controllers\LoginTenantController::class, 'submit'])->name('login.submit');
        });

        // Admin panel routes
        Route::name('admin.')->group(function () {
            Route::get('/admin/login', [Admin\AuthController::class, 'show'])->name('login');
            Route::post('/admin/login/submit', [Admin\AuthController::class, 'login'])->name('login.submit');

            Route::middleware('auth:admin')->group(function () {
                Route::post('/logout', [Admin\AuthController::class, 'logout'])->name('logout');

                Route::get('/admin/redirect/tenants', fn() => redirect(TenantResource::getUrl()))
                    ->name('tenants.index');
            });
        });

    });
}
