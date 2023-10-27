<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PaymentService
{
    public $httpClient;

    public function __construct(
        public bool $isDebug = true
    )
    {
        $client = Http::baseUrl(config('payment.api_url'));
        $client->withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ]);
        $this->httpClient = $client;
    }

    public function create($order_id, $amount)
    {

        /**
         * 1. Tao checksum tu key theo document
         * 2. Taoj data de gui len api theo fields trong document
         * 3. Goi api tao transaction
         * 4. Tao record trong bang payment_transactions chua thong tin lien ket den order hien tai
         * 5. Sau khi tao transaction xong, redirect user den url cua cong thanh toan trong api tra ve
         */
        $convertedAmount = $amount*24000;
        $checksum = md5(implode( "|" , [
            config('payment.access_code'),
            $convertedAmount,
            $order_id,
            config('payment.secret_key'),
        ]));

        $data = [
            'order_id' => $order_id,
            'amount' => $convertedAmount,
            'return_url' => $this->getRedirectUrl(config('payment.return_url')),
            'cancel_url' => $this->getRedirectUrl(config('payment.cancel_url')),
            'notification_url' => $this->getRedirectUrl(config('payment.notification_url')),
            'checksum' => $checksum
        ];
        Log::info("create transaction", $data);

        $response = $this->httpClient->asForm()->post('/checkout', $data);
        return $response->json();
    }

    public function detail($order_id)
    {
        /**
         * 1. Tao checksum theo format trong tai lieu
         * 2. Goi api lay thong tin transaction
         * 3. Cap nhat thong tin transaction vao bang payment_transactions
         * 4. Hien thi thong tin ket qua thanh toan cho nguoi dung
         */

        $checksum = md5(implode( "|" , [
            config('payment.access_code'),
            $order_id,
            config('payment.secret_key'),
        ]));

        $data = [
            'order_id' => $order_id,
            'checksum' => $checksum
        ];
        Log::info("Get Order Detail data", [
            $checksum,
            $data
        ]);

        $response = $this->httpClient->get('/get-transaction', $data);
        Log::info("Get Order Detail", [
            $response->json()
        ]);
        return $response->json();
    }

    protected function getRedirectUrl(string $routeName)
    {
        $route = route($routeName);
        $route = Str::replace(config('app.url'), config('payment.debug_host_name'), $route);
        return $route;
    }

}
