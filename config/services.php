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

    'facebook' => [
        'client_id' => '1976822485874033',
        'client_secret' => 'b9fc89077b734d823a31744fa8e8e544',
        'redirect' => '/auth/facebook/callback',
    ],

    'google' => [
        'client_id' => '634533009029-16holvukpj0bpineiibmil60e6ukhk7k.apps.googleusercontent.com',
        'client_secret' => 'NtcVLFObwhog-lDVTCWNOWOd',
        'redirect' => '/auth/google/callback',
    ],
];
