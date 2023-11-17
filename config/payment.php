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

    "api_url" => env('PAYMENT_API_URL', 'https://portal.foxpay.vn/payment'),
    "return_url" => env('PAYMENT_RETURN_URL', 'payment.return'),
    "cancel_url" => env('PAYMENT_CANCEL_URL', 'payment.cancel'),
    "version" => env('PAYMENT_VERSION', '3.0'),
    "merchant_id" => env('PAYMENT_MERCHANT_ID', '9350a4c5-338b-4a51-aad9-37a23e34bbba'),
    "terminal_id" => env('PAYMENT_TERMINAL_ID', '0b6318a1-d88f-4784-b50a-8862133983ef'),
    "return_token" => env('PAYMENT_RETURN_TOKEN', 'true'),
    "currency" => env('PAYMENT_CURRENCY', 'VND'),
    "merchant_secret_key" => env('PAYMENT_MERCHANT_SECRET_KEY', '0EA0377A939B474BC5F19F2676966CD699B55D860230AF20CC22A9072C385FA6'),
    "exchange" => [
        "usd" => env('PAYMENT_EXCHANGE_USD', 23500),
    ],
];
