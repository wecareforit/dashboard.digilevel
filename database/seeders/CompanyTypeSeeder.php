<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\companyType;

class CompanyTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         
        $data = [
            ['id' => 1, 'name' => 'Onderhoudspartij'],
            ['id' => 2, 'name' => 'Beheerder'],
            ['id' => 3, 'name' => 'Keuringsinstantie'],
            ['id' => 3, 'name' => 'Leveranciers']
        ];
            
        companyType::insert($data);
    }
}
