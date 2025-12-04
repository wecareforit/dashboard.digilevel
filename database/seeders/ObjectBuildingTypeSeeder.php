<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ObjectBuildingType;

class ObjectBuildingTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $buildingTypes = [
            ['is_active' => 1, 'name' => 'Appartementen'],
            ['is_active' => 1, 'name' => 'Appartementencomplex'],
            ['is_active' => 1, 'name' => 'Arbeiderswoning'],
            ['is_active' => 1, 'name' => 'Aula'],
            ['is_active' => 1, 'name' => 'Bankgebouw'],
            ['is_active' => 1, 'name' => 'Bedrijfsgebouw'],
            ['is_active' => 1, 'name' => 'Bedrijfsgebouw met woning(en)'],
            ['is_active' => 1, 'name' => 'Begeleid wonen'],
            ['is_active' => 1, 'name' => 'Begraafplaats'],
            ['is_active' => 1, 'name' => 'Bejaardentehuis, verzorgingstehuis'],
            ['is_active' => 1, 'name' => 'Bibliotheek'],
            ['is_active' => 1, 'name' => 'Bioscoop'],
            ['is_active' => 1, 'name' => 'Boerderij'],
            ['is_active' => 1, 'name' => 'Boven- en benedenwoningen'],
            ['is_active' => 1, 'name' => 'Brouwerij'],
            ['is_active' => 1, 'name' => 'Brug'],
            ['is_active' => 1, 'name' => 'Bungalow'],
            ['is_active' => 1, 'name' => 'Crematorium'],
            ['is_active' => 1, 'name' => 'Dienstgebouw'],
            ['is_active' => 1, 'name' => 'Eengezinswoning'],
            ['is_active' => 1, 'name' => 'Eengezinswoning in een rij'],
            ['is_active' => 1, 'name' => 'Expositiegebouw'],
            ['is_active' => 1, 'name' => 'Galerijflat'],
            ['is_active' => 1, 'name' => 'Galerijflat met bedrijfsruimte'],
            ['is_active' => 1, 'name' => 'Galerijwoningen'],
            ['is_active' => 1, 'name' => 'Gasthuis'],
            ['is_active' => 1, 'name' => 'Gerechtsgebouw'],
            ['is_active' => 1, 'name' => 'Gevangenis'],
            ['is_active' => 1, 'name' => 'Handelsgebouw'],
            ['is_active' => 1, 'name' => 'Herenhuis'],
            ['is_active' => 1, 'name' => 'Hotel-restaurant'],
            ['is_active' => 1, 'name' => 'Industriegebouw'],
            ['is_active' => 1, 'name' => 'Instelling'],
            ['is_active' => 1, 'name' => 'Jongerenhuisvesting'],
            ['is_active' => 1, 'name' => 'Kantoorgebouw'],
            ['is_active' => 1, 'name' => 'Kerkgebouw'],
            ['is_active' => 1, 'name' => 'Kerktoren'],
            ['is_active' => 1, 'name' => 'Kinderopvang'],
            ['is_active' => 1, 'name' => 'Kiosk'],
            ['is_active' => 1, 'name' => 'Koetshuis'],
            ['is_active' => 1, 'name' => 'Landhuis'],
            ['is_active' => 1, 'name' => 'Mantelzorgwoningen'],
            ['is_active' => 1, 'name' => 'Militair gebouw'],
            ['is_active' => 1, 'name' => 'Multifunctioneel woongebouw'],
            ['is_active' => 1, 'name' => 'Museumgebouw'],
            ['is_active' => 1, 'name' => 'Nutsgebouw'],
            ['is_active' => 1, 'name' => 'Onderwijsgebouw'],
            ['is_active' => 1, 'name' => 'Opbouw'],
            ['is_active' => 1, 'name' => 'Openbaar toilet'],
            ['is_active' => 1, 'name' => 'Overheidsgebouw'],
            ['is_active' => 1, 'name' => 'P+R voorziening'],
            ['is_active' => 1, 'name' => 'Pakhuis'],
            ['is_active' => 1, 'name' => 'Parkeergebouw'],
            ['is_active' => 1, 'name' => 'Patiowoningen'],
            ['is_active' => 1, 'name' => 'Patriciërshuis'],
            ['is_active' => 1, 'name' => 'Politiebureau'],
            ['is_active' => 1, 'name' => 'Pompgebouw, gemaal, sluis'],
            ['is_active' => 1, 'name' => 'Pompstation'],
            ['is_active' => 1, 'name' => 'Portiekflat'],
            ['is_active' => 1, 'name' => 'Portiekwoningen'],
            ['is_active' => 1, 'name' => 'Recreatieve voorziening'],
            ['is_active' => 1, 'name' => 'Religieus gebouw'],
            ['is_active' => 1, 'name' => 'Rentenierswoning'],
            ['is_active' => 1, 'name' => 'Restaurant'],
            ['is_active' => 1, 'name' => 'Rijwoningen'],
            ['is_active' => 1, 'name' => 'Schoolgebouw'],
            ['is_active' => 1, 'name' => 'Schouwburg'],
            ['is_active' => 1, 'name' => 'Seniorenwoningen'],
            ['is_active' => 1, 'name' => 'Sportgebouw'],
            ['is_active' => 1, 'name' => 'Stadsvilla'],
            ['is_active' => 1, 'name' => 'Startersappartementen'],
            ['is_active' => 1, 'name' => 'Stationsgebouw'],
            ['is_active' => 1, 'name' => 'Straatmeubilair'],
            ['is_active' => 1, 'name' => 'Studentenwoning'],
            ['is_active' => 1, 'name' => 'Theehuis'],
            ['is_active' => 1, 'name' => 'Tuinhuis'],
            ['is_active' => 1, 'name' => 'Tuinkoepel'],
            ['is_active' => 1, 'name' => 'Twee-onder-een-kapwoning'],
            ['is_active' => 1, 'name' => 'Universiteitsgebouw'],
            ['is_active' => 1, 'name' => 'Verenigingsgebouw'],
            ['is_active' => 1, 'name' => 'Villa'],
            ['is_active' => 1, 'name' => 'Vrijstaande woning'],
            ['is_active' => 1, 'name' => 'Warenhuis'],
            ['is_active' => 1, 'name' => 'Watertoren'],
            ['is_active' => 1, 'name' => 'Weeshuis'],
            ['is_active' => 1, 'name' => 'Wijkvoorzieningsgebouw'],
            ['is_active' => 1, 'name' => 'Winkel'],
            ['is_active' => 1, 'name' => 'Winkelcentrum'],
            ['is_active' => 1, 'name' => 'Winkelwoningcomplex'],
            ['is_active' => 1, 'name' => 'Woningen'],
            ['is_active' => 1, 'name' => 'Woon- werkgebouw'],
            ['is_active' => 1, 'name' => 'Woonhuis'],
            ['is_active' => 1, 'name' => 'Woonstudio'],
            ['is_active' => 1, 'name' => 'Ziekenhuis'],
            ['is_active' => 1, 'name' => 'Zorginstelling'],
            ['is_active' => 1, 'name' => 'Zwembad'],
        ];

        foreach ($buildingTypes as $type) {
            ObjectBuildingType::create($type);
        }
    }
}