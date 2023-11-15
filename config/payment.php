<?php

return [
//    "access_code" => env('PAYMENT_ACCESS_CODE', 'HUST'),
//    "secret_key" => env('PAYMENT_SECRET_KEY', '62721dbbe985d6ed22f8fd2e910b515f23a8f831425011'),
//    //"api_url" => env('PAYMENT_API_URL', 'https://api.tsa.xcbt-staging.xplat.online/my/apiv1/hust'),
//    "api_url" => env('PAYMENT_API_URL', 'https://portal-staging.foxpay.vn/payment/initiate'),
//    "return_url" => env('PAYMENT_RETURN_URL', 'payment.return'),
//    "cancel_url" => env('PAYMENT_CANCEL_URL', 'payment.cancel'),
//    "notification_url" => env('PAYMENT_NOTIFICATION_URL', 'payment.notification'),
    "debug_host_name" => env('PAYMENT_DEBUG_HOST_NAME', ''),
//    "exchange" => [
//        "usd" => env('PAYMENT_EXCHANGE_USD', 23500),
//    ],

    "api_url" => env('PAYMENT_API_URL', 'https://portal-staging.foxpay.vn/payment'),
    "return_url" => env('PAYMENT_RETURN_URL', 'payment.return'),
    "cancel_url" => env('PAYMENT_CANCEL_URL', 'payment.cancel'),
    "version" => env('PAYMENT_VERSION', '3.0'),
    "merchant_id" => env('PAYMENT_MERCHANT_ID', '9266c734-d708-47cb-8e0b-4b09795d0b5a'),
    "terminal_id" => env('PAYMENT_TERMINAL_ID', '35189e84-fa1b-41f4-835e-ea9b7d0e3e60'),
    "return_token" => env('PAYMENT_RETURN_TOKEN', 'true'),
    "currency" => env('PAYMENT_CURRENCY', 'VND'),
    "merchant_secret_key" => env('PAYMENT_MERCHANT_SECRET_KEY', '341C9C7BE9363E76806CE7030E0BD24D06D1110BFA5D8B891BED839F7B0A56BB'),
    "exchange" => [
        "usd" => env('PAYMENT_EXCHANGE_USD', 23500),
    ],
];
