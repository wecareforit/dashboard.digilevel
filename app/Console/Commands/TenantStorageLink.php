<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tenant;

class TenantStorageLink extends Command
{
    protected $signature = 'tenant:storage-link';
    protected $description = 'Create storage symlinks for all tenants';

    public function handle()
    {
        $tenants = Tenant::all();

        foreach ($tenants as $tenant) {
            $source = storage_path("app/tenants/{$tenant->code}/uploads");
            $target = public_path("tenants/{$tenant->code}");

            // 1️⃣ Ensure source exists
            if (!file_exists($source)) {
                mkdir($source, 0755, true);
                $this->info("Created source folder: {$source}");
            }

            // 2️⃣ Ensure parent of target exists
            $targetParent = dirname($target);
            if (!file_exists($targetParent)) {
                mkdir($targetParent, 0755, true);
                $this->info("Created target parent folder: {$targetParent}");
            }

            // 3️⃣ Create symlink if it doesn't exist
            if (!file_exists($target)) {
                if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                    // Windows: create directory junction
                    exec("mklink /J \"{$target}\" \"{$source}\"");
                } else {
                    // Linux/macOS: normal symlink
                    symlink($source, $target);
                }
                $this->info("Symlink created for tenant {$tenant->code}");
            } else {
                $this->info("Symlink already exists for tenant {$tenant->code}");
            }
        }
    }
}
