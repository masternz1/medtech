<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Paystack Configuration
    |--------------------------------------------------------------------------
    | API credentials for Paystack payment gateway.
    | Never commit real credentials — use .env file.
    */

    'public_key'      => env('PAYSTACK_PUBLIC_KEY'),
    'secret_key'      => env('PAYSTACK_SECRET_KEY'),
    'payment_url'     => env('PAYSTACK_PAYMENT_URL', 'https://api.paystack.co'),
    'webhook_secret'  => env('PAYSTACK_WEBHOOK_SECRET'),

    /*
    | Merchant channels to support
    | Options: card, bank, ussd, qr, mobile_money, bank_transfer
    */
    'channels' => ['card', 'bank', 'ussd', 'bank_transfer'],

    /*
    | Currency — Paystack supports NGN, GHS, ZAR, USD, KES, UGX, TZS, EGP
    */
    'currency' => env('DEFAULT_CURRENCY', 'NGN'),
];
