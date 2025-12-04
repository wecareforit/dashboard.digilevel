<?php

return [
    'singular' => 'Medewerker',
    'plural' => 'Medewerkers',
    'nav_group' => 'Medewerkers',

    'fields' => [
        'name' => 'Naam',
        'first_name' => 'Voornaam',
        'infix' => 'Tussenvoegsel',
        'last_name' => 'Achternaam',
        'email' => 'E-mailadres',
        'date_of_birth' => 'Geboortedatum',
        'private_email' => 'Privé e-mailadres',
        'private_phone' => 'Privé telefoonnummer',
        'private_street' => 'Privé straat',
        'private_house_number' => 'Privé huisnummer',
        'private_house_number_addition' => 'Privé huisnummer toevoeging',
        'private_postal_code' => 'Privé postcode',
        'private_city' => 'Privé woonplaats',
        'private_country' => 'Privé land',
        'password' => 'Wachtwoord',
        'password_confirm' => 'Wachtwoord controle',
        'created_at' => 'Aangemaakt op',
        'updated_at' => 'Bijgewerkt op',
    ],

    'sections' => [
        'private' => [
            'title' => 'Privé gegevens',
            'description' => 'Vul hier de privé gegevens van de gebruiker in',

            'fields' => [
                'private_email' => 'E-mailadres',
                'private_phone' => 'Telefoonnummer',
                'private_street' => 'Straat',
                'private_house_number' => 'Huisnummer',
                'private_house_number_addition' => 'Toevoeging',
                'private_postal_code' => 'Postcode',
                'private_city' => 'Woonplaats',
                'private_country' => 'Land',
            ],
        ],
        'twoN' => [
            'title' => '2N gegevens',
            'description' => '',
        ],
    ],
];
