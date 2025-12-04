<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

class MigrateTenants extends Command
{
    protected $signature = 'migrate:tenant';
    protected $description = 'Run migrations for all tenant databases safely';

    public function handle()
    {
        $tenants = DB::table('tenants')->get();

        foreach ($tenants as $tenant) {
            $this->info("Migrating tenant: {$tenant->name}");

            $connectionName = 'tenant_' . $tenant->id;

            // Dynamically add tenant connection if it does not exist
            if (!array_key_exists($connectionName, config('database.connections'))) {
                config([
                    "database.connections.$connectionName" => [
                        'driver' => 'mysql',
                        'host' => env('DB_HOST', '127.0.0.1'),
                        'port' => env('DB_PORT', '3306'),
                        'database' => $tenant->database,
                        'username' => env('DB_USERNAME'), // use .env credentials
                        'password' => env('DB_PASSWORD'), // use .env credentials
                        'charset' => 'utf8mb4',
                        'collation' => 'utf8mb4_unicode_ci',
                        'prefix' => '',
                        'strict' => true,
                    ],
                ]);
            }

            try {
                // Run migrations for this tenant
                Artisan::call('migrate', [
                    '--database' => $connectionName,
                    '--path' => '/database/migrations/tenant', // optional for tenant-specific migrations
                    '--force' => true,
                ]);

                $this->info(Artisan::output());
            } catch (\Exception $e) {
                // Skip errors like "table already exists" and continue
                $this->warn("Skipped tenant {$tenant->name}: " . $e->getMessage());
            }

            // Disconnect after migration to free resources
            DB::disconnect($connectionName);
        }

        $this->info('All tenant migrations processed successfully!');
    }
}
