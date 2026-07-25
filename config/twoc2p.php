<?php

/*
|--------------------------------------------------------------------------
| 2C2P SCB Payment Gateway v4.3 Configuration
|--------------------------------------------------------------------------
|
| Credentials and settings for the 2C2P (Second To None) payment gateway.
| Switch TWOC2P_ENV between 'sandbox' and 'production' in your .env file.
|
*/

$isSandbox = env('TWOC2P_ENV', 'sandbox') === 'sandbox';

return [

    /*
    |--------------------------------------------------------------------------
    | Environment
    |--------------------------------------------------------------------------
    | 'sandbox' — use test credentials against sandbox-pgw.2c2p.com
    | 'production' — use live credentials against pgw.2c2p.com
    */
    'env' => env('TWOC2P_ENV', 'sandbox'),

    /*
    |--------------------------------------------------------------------------
    | Invoice Prefix
    |--------------------------------------------------------------------------
    | Prepended to every invoice number to prevent collisions across merchants.
    | Format: DDC-YYYYMMDD-XXXXXXXX (hex-encoded order ID, zero-padded to 8 chars)
    */
    'invoice_prefix' => env('TWOC2P_INVOICE_PREFIX', 'DDC'),

    /*
    |--------------------------------------------------------------------------
    | Active Credentials (resolved from env)
    |--------------------------------------------------------------------------
    */
    'base_url' => $isSandbox
        ? env('TWOC2P_SBX_BASE_URL', 'https://sandbox-pgw.2c2p.com')
        : env('TWOC2P_PROD_BASE_URL', 'https://pgw.2c2p.com'),

    // Master Merchant ID (SCB00) — used as fallback
    'merchant_id' => $isSandbox
        ? env('TWOC2P_SBX_MERCHANT_ID')
        : env('TWOC2P_PROD_MERCHANT_ID'),

    // Credit / Debit Card Merchant ID (SCB01)
    'merchant_id_card' => $isSandbox
        ? env('TWOC2P_SBX_MERCHANT_ID_CARD')
        : env('TWOC2P_PROD_MERCHANT_ID_CARD'),

    // PromptPay / QR / Wallet Merchant ID (SCB02)
    'merchant_id_qr' => $isSandbox
        ? env('TWOC2P_SBX_MERCHANT_ID_QR')
        : env('TWOC2P_PROD_MERCHANT_ID_QR'),

    // SHA/Secret Key for HMAC signature
    'secret_key' => $isSandbox
        ? env('TWOC2P_SBX_SECRET_KEY')
        : env('TWOC2P_PROD_SECRET_KEY'),

    // Report Key (for reconciliation reports)
    'report_key' => env('TWOC2P_PROD_REPORT_KEY'),

    /*
    |--------------------------------------------------------------------------
    | API Endpoints
    |--------------------------------------------------------------------------
    */
    'endpoints' => [
        'payment'  => '/payment/4.3/payment',
        'inquiry'  => '/payment/4.3/paymentInquiry',
    ],

    /*
    |--------------------------------------------------------------------------
    | Currency & Locale
    |--------------------------------------------------------------------------
    */
    'currency'         => '764',   // ISO 4217 numeric: THB
    'frontend_lang'    => 'th',

    /*
    |--------------------------------------------------------------------------
    | All Credentials (for reference / raw access)
    |--------------------------------------------------------------------------
    */
    'production' => [
        'base_url'         => env('TWOC2P_PROD_BASE_URL', 'https://pgw.2c2p.com'),
        'merchant_id'      => env('TWOC2P_PROD_MERCHANT_ID'),
        'merchant_id_card' => env('TWOC2P_PROD_MERCHANT_ID_CARD'),
        'merchant_id_qr'   => env('TWOC2P_PROD_MERCHANT_ID_QR'),
        'secret_key'       => env('TWOC2P_PROD_SECRET_KEY'),
        'report_key'       => env('TWOC2P_PROD_REPORT_KEY'),
    ],

    'sandbox' => [
        'base_url'         => env('TWOC2P_SBX_BASE_URL', 'https://sandbox-pgw.2c2p.com'),
        'merchant_id'      => env('TWOC2P_SBX_MERCHANT_ID'),
        'merchant_id_card' => env('TWOC2P_SBX_MERCHANT_ID_CARD'),
        'merchant_id_qr'   => env('TWOC2P_SBX_MERCHANT_ID_QR'),
        'secret_key'       => env('TWOC2P_SBX_SECRET_KEY'),
    ],
];
