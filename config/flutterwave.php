<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Flutterwave Configuration
    |--------------------------------------------------------------------------
    | API credentials for Flutterwave payment gateway.
    | Never commit real credentials — use .env file.
    */

    'public_key'    => env('FLUTTERWAVE_PUBLIC_KEY'),
    'secret_key'    => env('FLUTTERWAVE_SECRET_KEY'),
    'secret_hash'   => env('FLUTTERWAVE_SECRET_HASH'),
    'base_url'      => 'https://api.flutterwave.com/v3',

    /*
    | Payment methods to enable
    */
    'payment_options' => 'card, banktransfer, ussd, account',

    /*
    | Currency
    */
    'currency' => env('DEFAULT_CURRENCY', 'NGN'),

    /*
    | Redirect URL after payment
    */
    'redirect_url' => env('APP_URL') . '/checkout/flutterwave/callback',
];
