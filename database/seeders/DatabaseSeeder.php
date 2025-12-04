<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */

    public function run(): void
    {
        Admin::create([
            'name' => 'Super Admin',
            'email' => 'admin@digilevel.nl',
            'password' => Hash::make('aNC>6241RrK'), 
        ]);
    }
}
