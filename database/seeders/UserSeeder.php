<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            ['name' => 'Alice Johnson', 'email' => 'alice@example.com'],
            ['name' => 'Bob Smith', 'email' => 'bob@example.com'],
            ['name' => 'Charlie Brown', 'email' => 'charlie@example.com'],
            ['name' => 'David Wilson', 'email' => 'david@example.com'],
            ['name' => 'Emma Davis', 'email' => 'emma@example.com'],
            ['name' => 'Frank Thomas', 'email' => 'frank@example.com'],
            ['name' => 'Grace Lee', 'email' => 'grace@example.com'],
            ['name' => 'Henry Martin', 'email' => 'henry@example.com'],
            ['name' => 'Isabel White', 'email' => 'isabel@example.com'],
            ['name' => 'Jack Taylor', 'email' => 'jack@example.com'],
        ];

        // foreach ($users as $user) {
        //     User::create([
        //         'name' => $user['name'],
        //         'email' => $user['email'],
        //         'password' => bcrypt('password123'), // Standaard wachtwoord
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ]);
        // }
    }
}
