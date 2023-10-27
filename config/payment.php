<?php

return [
    "access_code" => env('PAYMENT_ACCESS_CODE', 'HUST'),
    "secret_key" => env('PAYMENT_SECRET_KEY', '62721dbbe985d6ed22f8fd2e910b515f23a8f831425011'),
    "api_url" => env('PAYMENT_API_URL', 'https://api.tsa.xcbt-staging.xplat.online/my/apiv1/hust'),
    "return_url" => env('PAYMENT_RETURN_URL', 'payment.return'),
    "cancel_url" => env('PAYMENT_CANCEL_URL', 'payment.cancel'),
    "notification_url" => env('PAYMENT_NOTIFICATION_URL', 'payment.notification'),
    "debug_host_name" => env('PAYMENT_DEBUG_HOST_NAME', ''),
];
