<?php

// In AppServiceProvider or a custom provider
use Illuminate\Support\Facades\Storage;
use League\Flysystem\Filesystem;
use League\Flysystem\Local\LocalFilesystemAdapter;
use League\Flysystem\Prefixer\PrefixingAdapter;

class TenantStorageServiceProvider extends ServiceProvider
{

    public function boot()
    {
        Storage::extend('tenant', function ($app, $config) {
            $tenantId = "sss"; // Use your own tenant resolution logic
            $prefix   = "tenants/{$tenantId}";

            $adapter         = new LocalFilesystemAdapter($config['root']);
            $prefixedAdapter = new PrefixingAdapter($adapter, $prefix);

            return new Filesystem($prefixedAdapter);
        });
    }

}
