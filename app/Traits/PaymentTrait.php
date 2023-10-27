<?php

namespace App\Traits;

use App\Enums\OrderStatusEnum;
use App\Enums\PaymentStatusEnum;
use App\Models\Order;
use App\Models\Transaction;
use App\Services\PaymentService;
use Illuminate\Support\Facades\Log;

trait PaymentTrait
{
    public function fetchTransaction(int $orderId)
    {
        $payment = app(PaymentService::class)->detail($orderId);
        Log::info("Order result", [$payment]);

        $paymentData = $payment['data'];

        $order = Order::findOrFail($orderId);
        $transaction = optional($order)->transaction;
        if (empty($transaction)) {
            $transaction = new Transaction();
        }

        $transactionData = array_merge(
            $transaction->toArray(),
            $paymentData
        );
        $transaction->fill($transactionData)->save();

        // Thanh toan thanh cong => update trang thai order va post
        if ($transaction->payment_status === PaymentStatusEnum::PAYMENT_SUCCESS->value) {
            $order->update(['status' => OrderStatusEnum::PAID->value]);
        }

        return $order->load('transaction')->toArray();
    }
}
