<?php

return [
    'singular' => 'Categorie',
    'plural' => 'Categorieën',

    'sub' => [
        'singular' => 'Subcategorie',
        'plural' => 'Subcategorieën',
    ],

    'fields' => [
        'name' => 'Naam',
        'supplier' => 'Leverancier',
        'created_at' => 'Aangemaakt op',
        'updated_at' => 'Bijgewerkt op',

        'metadata' => [
            'label' => 'Informatie velden',

            'key' => 'Veld',
            'type' => [
                'label' => 'Type',

                'options' => [
                    'text' => 'Tekst',
                    'number' => 'Nummer',
                    'date' => 'Datum',
                ],
            ],
            'value' => 'Waarde',
        ],
    ],
];
