<?php

return [
    'singular' => 'Verzoek',
    'plural' => 'Verzoeken',

    'fields' => [
        'steps' => [
            'new_asset' => [
                'label' => 'Nieuwe asset aanvragen',
                'description' => 'Selecteer de categorie die je wilt aanvragen, wil je alleen een asset verwijderen. Klik dan geen categorie aan.',
            ],
            'remove_asset' => [
                'label' => 'Asset verwijder aanvraag',
                'description' => 'Selecteer de categorie die je wilt verwijderen, wil je alleen een asset aanvragen. Klik dan geen asset aan.',
                'no_assets' => 'Er zijn geen assets om te verwijderen.',
            ],
        ],
        'category' => 'Categorie',
        'type' => 'Type',
        'status' => 'Status',
        'model' => 'Model',
        'asset' => 'Asset',
        'serial_number' => 'Serienummer',
        'requested_by' => 'Aangevraagd door',
        'created_at' => 'Aangemaakt op',
        'updated_at' => 'Bijgewerkt op',
    ],
];
