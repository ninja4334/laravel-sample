<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Unit.Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, Mandrill, and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key'    => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model'    => App\Models\UserStripe::class,
        'key'      => env('STRIPE_KEY'),
        'secret'   => env('STRIPE_SECRET'),
        'card_fee' => [
            'percentages' => 2.9,
            'amount'      => 0.3
        ],
        'bank_fee' => [
            'percentages' => 0.8,
            'additional'  => [
                'limit'  => 625,
                'amount' => 5
            ]
        ]
    ],

];
