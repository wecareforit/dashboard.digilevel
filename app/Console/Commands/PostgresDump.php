<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;

class PostgresDump extends Command
{
    protected $signature = 'db:pg-dump {--path= : Optioneel pad om het dumpbestand op te slaan}';
    protected $description = 'Maakt een dump van de PostgreSQL database';

    public function handle()
    {
        $database = Config::get('database.connections.pgsql.database');
        $username = Config::get('database.connections.pgsql.username');
        $password = Config::get('database.connections.pgsql.password');
        $host = Config::get('database.connections.pgsql.host');
        $port = Config::get('database.connections.pgsql.port', 5432);

        $timestamp = now()->format('Ymd_His');
        $filename = "pg_dump_{$timestamp}.sql";
        $path = $this->option('path') ?? base_path($filename);

        $this->info("📦 Database dump wordt gemaakt...");

        $command = sprintf(
            'PGPASSWORD="%s" pg_dump -U %s -h %s -p %s %s > %s',
            $password,
            $username,
            $host,
            $port,
            $database,
            escapeshellarg($path)
        );

        $result = null;
        $output = null;
        exec($command, $output, $result);

        if ($result === 0) {
            $this->info("✅ Dump succesvol opgeslagen als: $path");
        } else {
            $this->error("❌ Dump mislukt. Controleer pg_dump en je databaseconfiguratie.");
        }
    }
}