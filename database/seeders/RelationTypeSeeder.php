<?php
namespace Database\Seeders;

use App\Models\relationType;
use Illuminate\Database\Seeder;

class RelationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $RelationTypes = [
            ['id' => '1', 'name' => 'Onderhoudsbedrijf', 'is_active' => '1'],
            ['id' => '2', 'name' => 'Beheerder', 'is_active' => '1'],
            ['id' => '3', 'name' => 'Keuringsinstantie', 'is_active' => '1'],
            ['id' => '4', 'name' => 'Leverancier', 'is_active' => '1'],
            ['id' => '5', 'name' => 'Klanten', 'is_active' => '1'],
            ['id' => '6', 'name' => 'Adviesbureau', 'is_active' => '1'],
        ];

        foreach ($RelationTypes as $RelationType) {
            relationType::create([
                'id'         => $RelationType['id'],
                'name'       => $RelationType['name'],
                'is_active'  => $RelationType['is_active'],
                'created_at' => now(),
            ]);
        }

    }
}
