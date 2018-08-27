<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],
    'nexmo' => [
        'key' => env('NEXMO_KEY'),
        'secret' => env('NEXMO_SECRET'),
        'sms_from' => '573135595065',
    ],
    'facebook' => [
        'client_id' => '1562152613820901',
        'client_secret' => '1fe63d814a10a92df421d7719261c3ff',
        'redirect' => 'http://localhost:8000/auth/facebook/callback'
    ],
    'instagram' => [
        'client_id' => '3f00294288254df0beddf9dfd3c0c044',
        'client_secret' => '7fb9c34b14d64d879a3f2787dd740329',
        'redirect' => 'http://localhost:8000/auth/instagram/callback'
    ],
    'google' => [
        //Id suministrado por google
        'client_id'     => '698967351154-qm8tfnvjftvpd5f2hgq2jqsr5koaqv6i.apps.googleusercontent.com',
        //Secret suministrado por google
        'client_secret' => '3Cu4RSH8pphPkih7VBTcijy4',
        //Página a la que sera redireccionado el navegador cuando el login se exitoso
        //Ejemplo: http://midominio.com/social/handle/google
        'redirect'      => 'http://localhost:8000/auth/google/callback'
    ]
];
