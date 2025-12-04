<?php
namespace Database\Seeders;

use App\Models\Relation;
use Illuminate\Database\Seeder;

class InspectionCompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $relations = [
            [
                'name'         => 'Aboma Inspections B.V.',
                'zipcode'      => '6716 BX',
                'address'      => 'Maxwellstraat 49a',
                'place'        => 'Ede',
                'emailaddress' => 'info@aboma.nl',
                'website'      => 'www.aboma.nl',
                'post_address' => 'Postbus 141',
                'post_zipcode' => '6710 BC',
                'post_place'   => 'Ede',
                'phonenumber'  => '0318691920',
            ],
            [
                'name'         => 'Gevellift Keuring',
                'zipcode'      => '',
                'address'      => '',
                'place'        => '',
                'emailaddress' => 'info@gevellift-keuring.nl',
                'website'      => 'www.gevellift-keuring.nl',
                'post_address' => '',
                'post_zipcode' => '',
                'post_place'   => '',
                'phonenumber'  => '0623227041',
            ],
            [
                'name'         => 'Liftinstituut B.V.',
                'zipcode'      => '1025 XE',
                'address'      => 'Buikslotermeerplein 381',
                'place'        => 'Amsterdam',
                'emailaddress' => 'info@liftinstituut.nl',
                'website'      => 'www.liftinstituut.nl',
                'post_address' => 'Postbus 36027',
                'post_zipcode' => '1020 MA',
                'post_place'   => 'Amsterdam',
                'phonenumber'  => '0204350606',
            ],
            [
                'name'         => 'Chex Liftkeuringen.',
                'zipcode'      => '1171 LP',
                'address'      => 'Prins Mauritslaan 33',
                'place'        => 'Badhoevedorp',
                'emailaddress' => 'info@chex.nl',
                'website'      => 'www.chex.nl',
                'post_address' => '',
                'post_zipcode' => '',
                'post_place'   => '',
                'phonenumber'  => '0206674209',
            ],
            [
                'name'         => 'TUV Nederland',
                'zipcode'      => '',
                'address'      => '',
                'place'        => '',
                'emailaddress' => '',
                'website'      => '',
                'post_address' => '',
                'post_zipcode' => '',
                'post_place'   => '',
                'phonenumber'  => '',
            ],

        ];

        foreach ($relations as $relation) {
            Relation::create([
                'name'         => $relation['name'],
                'zipcode'      => $relation['zipcode'],
                'address'      => $relation['address'],
                'place'        => $relation['place'],
                'emailaddress' => $relation['emailaddress'],
                'type_id'      => 3,
                'created_at'   => now(),
            ]);
        }

    }
}
