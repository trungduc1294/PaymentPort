<?php

namespace App\Services;

use App\Models\Order;
use App\Models\User;
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
         * 4. Taao record trong bang payment_transactions chua thong tin lien ket den order hien ti
         * 5. Sau khi tao transaction xong, redirect user den url cua cong thanh toan trong api tra ve
         */

//        [version][merchant_id][terminal_id][order_id][payment_method][amount][currency][device_id]
//        [return_token][token][description][items][customer][return_url][cancel_url][voucher_code]
//          [merchant secret key]

        $userId = Order::where('order_uid', $order_id)->firstOrFail()->user_id;
        $convertedAmount = $amount*config('payment.exchange.usd');
        $signatureString = implode("", [
            config('payment.version'),
            config('payment.merchant_id'),
            config('payment.terminal_id'),
            $order_id,
            $convertedAmount,
            config('payment.currency'),
            $userId, //deviceID
            config('payment.return_token'),
            $this->getRedirectUrl(config('payment.return_url')),
            $this->getRedirectUrl(config('payment.cancel_url')),
            config('payment.merchant_secret_key')
        ]);
        Log::info("2. data to gen signature: ", [
            [
                config('payment.version'),
                config('payment.merchant_id'),
                config('payment.terminal_id'),
                $order_id,
                $convertedAmount,
                config('payment.currency'),
                $userId, //deviceID
                config('payment.return_token'),
                $this->getRedirectUrl(config('payment.return_url')),
                $this->getRedirectUrl(config('payment.cancel_url')),
                config('payment.merchant_secret_key')
            ]
        ]);

        $signature = hash('sha256', $signatureString);
        Log::info("3. SHD256 signature code: ", [
            $signature
        ]);

        $data = [
            'version' => config('payment.version'),
            'merchant_id' => config('payment.merchant_id'),
            'terminal_id' => config('payment.terminal_id'),
            'order_id' => $order_id,
            'payment_method' => '',
            'amount' => $convertedAmount,
            'currency' => config('payment.currency'),
            'device_id' => $userId,
            'return_token' => config('payment.return_token'),
            'token' => '',
            'description' => '',
            'return_url' => $this->getRedirectUrl(config('payment.return_url')),
            'cancel_url' => $this->getRedirectUrl(config('payment.cancel_url')),
            'items' => '',
            'customer' => '',
            'voucher_code' => '',
            'signature' => $signature
        ];
        Log::info("4. Request Data to get PaymentUrl: ", $data);

        $response = $this->httpClient->post('/initiate', $data);
        Log::info("5. create transaction response: ", [
            $response->json()
        ]);
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

        $signatureString = implode("", [
            config('payment.version'),
            config('payment.merchant_id'),
            config('payment.terminal_id'),
            $order_id,
            config('payment.merchant_secret_key')
        ]);
        $signature = hash('sha256', $signatureString);

        $data = [
            'version' => config('payment.version'),
            'merchant_id' => config('payment.merchant_id'),
            'terminal_id' => config('payment.terminal_id'),
            'order_id' => $order_id,
            'signature' => $signature
        ];
        Log::info("Get Order Detail data", [
            $signatureString,
            $data
        ]);

        $response = $this->httpClient->get('/get-transaction/', $data);
        Log::info("Get Order Detail Response", [
            $response->json()
        ]);
        return $response->json();
    }

    protected function getRedirectUrl(string $routeName)
    {
        $route = route($routeName);


        if (!empty(config('payment.debug_host_name'))) {
            $route = Str::replace(config('app.url'), config('payment.debug_host_name'), $route);
        }

        return $route;
    }

}
