<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ObjectType;

class ObjectTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['id' => 1, 'is_active' => 1, 'name' => 'Personenlift'],
            ['id' => 2, 'is_active' => 1, 'name' => 'Magazijnlift'],
            ['id' => 3, 'is_active' => 1, 'name' => 'Goederenlift'],
            ['id' => 4, 'is_active' => 1, 'name' => 'Hefplatformlift'],
            ['id' => 5, 'is_active' => 1, 'name' => 'Autolift'],
            ['id' => 6, 'is_active' => 1, 'name' => 'Keukenlift'],
            ['id' => 7, 'is_active' => 1, 'name' => 'Beddenlift'],
            ['id' => 8, 'is_active' => 1, 'name' => 'Platform'],
            ['id' => 9, 'is_active' => 1, 'name' => 'Hefplateau of plateaulift'],
            ['id' => 10, 'is_active' => 1, 'name' => 'Gevellift'],
        ];

        ObjectType::insert($data);
    }
}
