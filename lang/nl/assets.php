<?php

return [
    'singular' => 'Asset',
    'plural' => 'Hardwarebeheer',

    'fields' => [
        'name' => 'Name',
        'serial_number' => 'Serienummer',
        'category' => [
            'label' => 'Categorie',
            'helper' => 'Na het selecteren van een categorie worden de velden voor de metadata automatisch ingevuld, indien ze al zijn ingevuld zal dit niet gebeuren.',
        ],
        'model' => [
            'label' => 'Model',
            'helper' => 'Na het selecteren van een model worden de velden voor de metadata automatisch ingevuld, indien ze al zijn ingevuld zal dit niet gebeuren.',
            'brand' => [
                'label' => 'Merk',
            ],
        ],
        'location' => 'Locatie',
        'supplier' => 'Leverancier',
        'claimer' => [
            'label' => 'Uitgegeven aan',
            'types' => [
                'user' => 'Gebruiker',
                'workplace' => 'Werkplek',
            ],
        ],
        'created_at' => 'Aangemaakt op',
        'updated_at' => 'Bijgewerkt op',
    ],
];
