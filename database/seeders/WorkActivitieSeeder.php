<?php
namespace Database\Seeders;

use App\Models\workorderActivities;
use Illuminate\Database\Seeder;

class WorkActivitieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $types = [
            ['name' => 'Verhuur', 'is_active' => '1'],
            ['name' => 'Verkoop', 'is_active' => '1'],
            ['name' => 'Storing', 'is_active' => '1'],
            ['name' => 'Service', 'is_active' => '1'],
            ['name' => 'Reparatie', 'is_active' => '1'],
            ['name' => 'Project', 'is_active' => '1'],
            ['name' => 'Onderhoud', 'is_active' => '1'],
            ['name' => 'Levering', 'is_active' => '1'],
            ['name' => 'Installatie', 'is_active' => '1'],
            ['name' => 'Garantie', 'is_active' => '1'],

        ];

        foreach ($types as $type) {
            workorderActivities::create([
                'name'       => $type['name'],
                'is_active'  => $type['is_active'],
                'created_at' => now(),
            ]);
        }

    }
}
