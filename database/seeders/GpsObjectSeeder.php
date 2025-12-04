<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GpsObject;
use App\Models\Company;

class GpsObjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $companies = Company::all();

        if ($companies->isEmpty()) {
            $this->command->warn('No companies found. Please seed companies first.');
            return;
        }

        $gpsObjects = [
            ['imei' => '123456789012345', 'name' => 'Tracker A', 'model' => 'GT-100', 'active' => 'yes'],
            ['imei' => '987654321098765', 'name' => 'Tracker B', 'model' => 'GT-200', 'active' => 'no'],
            ['imei' => '456789012345678', 'name' => 'Tracker C', 'model' => 'GT-300', 'active' => 'yes'],
            ['imei' => '654321098765432', 'name' => 'Tracker D', 'model' => 'GT-400', 'active' => 'no'],
            ['imei' => '789012345678901', 'name' => 'Tracker E', 'model' => 'GT-500', 'active' => 'yes'],
            ['imei' => '890123456789012', 'name' => 'Tracker F', 'model' => 'GT-600', 'active' => 'yes'],
            ['imei' => '210987654321098', 'name' => 'Tracker G', 'model' => 'GT-700', 'active' => 'no'],
            ['imei' => '345678901234567', 'name' => 'Tracker H', 'model' => 'GT-800', 'active' => 'yes'],
            ['imei' => '567890123456789', 'name' => 'Tracker I', 'model' => 'GT-900', 'active' => 'no'],
            ['imei' => '678901234567890', 'name' => 'Tracker J', 'model' => 'GT-1000', 'active' => 'yes'],
        ];

        foreach ($gpsObjects as $gpsObject) {
            GpsObject::create([
                'imei' => $gpsObject['imei'],
                'name' => $gpsObject['name'],
                'model' => $gpsObject['model'],
                'active' => $gpsObject['active'],
                'company_id' => $companies->random()->id, // Assign a random company
                'object_expire' => now()->addYear()->format('Y-m-d'),
                'object_expire_dt' => now()->addYear(),
            ]);
        }
    }
}
