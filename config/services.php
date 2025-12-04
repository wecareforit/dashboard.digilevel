<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'azure'       => [
        'client_id'     => env('AZURE_CLIENT_ID'),
        'client_secret' => env('AZURE_CLIENT_SECRET'),
        'redirect'      => env('AZURE_REDIRECT_URI'),
        'tenant'        => env('AZURE_TENANT_ID'),
        'proxy'         => env('PROXY'), // optionally
    ],

    'postmark'    => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses'         => [
        'key'    => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'resend'      => [
        'key' => env('RESEND_KEY'),
    ],

    'slack'       => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel'              => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    //API integrations
    'modusystem'  => [
        'url'      => env('MODUSYSTEM_URL', 'mqtt.lift-online.eu'),
        'port'     => env('MODUSYSTEM_PORT', '8883'),
        'topic'    => env('MODUSYSTEM_TOPIC'),
        'username' => env('MODUSYSTEM_USERNAME'),
        'password' => env('MODUSYSTEM_PASSWORD'),
    ],
    'rdw'         => [
        'url'   => env('RDW_URL', 'https://opendata.rdw.nl/resource'),
        'token' => env('RDW_TOKEN'),
    ],

    'eboekhouden' => [
        'url' => 'https://api.e-boekhouden.nl/',
    ],

    'pro6pp'      => [
        'url'   => env('3PRO6PP_HOST', 'https://api.pro6pp.nl'),
        'token' => env('3PRO6PP_TOKEN'),
    ],

    'cargps'      => [
        'token' => env('GPS_TRACKING_KEY', '222'),
        'url'   => env('GPS_TRACKING_URL', 'https://portaallovetracking.com/api_po/'),
    ],

    'tomtom'      => [
        'token' => env('TOMTOM_TOKEN', '222'),
        'url'   => env('TOMTOM_URL', 'https://api.tomtom.com/search/2'),
    ],

    'teamleader'  => [
        'client_id'     => env('TEAMLEADER_CLIENT_ID'),
        'client_secret' => env('TEAMLEADER_CLIENT_SECRET'),
        'redirect_url'  => env('TEAMLEADER_REDIRECT_URL'),
        'state'         => env('TEAMLEADER_STATE', 'FtvPC1SE2h3LVPEJZIsrfaVWTwwn7T0R'),
    ],

    'chex'        => [
        'token'      => env('CHEX_TOKEN'),
        'url'        => env('CHEX_URL', 'https://api.chex.nl/api/v1'),
        'company_id' => env('CHEX_COMPANY_ID'),
    ],

];

//ek8t0q4zzqagmmale1uq5yukp
