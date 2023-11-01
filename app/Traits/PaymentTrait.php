<?php

namespace App\Traits;

use App\Enums\OrderStatusEnum;
use App\Enums\PaymentStatusEnum;
use App\Models\Order;
use App\Models\Post;
use App\Models\Presenter;
use App\Models\Transaction;
use App\Models\User;
use App\Services\PaymentService;
use Illuminate\Support\Facades\Log;
use Mail;

trait PaymentTrait
{

    public function generateRandomCode() {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $code = '';
        for ($i = 0; $i < 6; $i++) {
            $code .= $characters[rand(0, $charactersLength - 1)];
        }
        return $code;
    }

    public function fetchTransaction($orderId)
    {
        // Lấy thông tin thanh toán từ payment service
        $payment = app(PaymentService::class)->detail($orderId);
        Log::info("Order result", [$payment]);

        // Lưu thông tin thanh toán vào transaction
        $paymentData = $payment['data'];

        // Lấy thông tin order
        $order = Order::where('order_uid', $orderId)->firstOrFail();
        $transaction = optional($order)->transaction;
        if (empty($transaction)) {
            $transaction = new Transaction();
        }

        // Cập nhật thông tin thanh toán vào transaction
        $transactionData = array_merge(
            $transaction->toArray(),
            $paymentData,
            ['order_id' => $order->id]
        );
        $transaction->fill($transactionData)->save();

        // Thanh toan thanh cong => update trang thai order
        if ($transaction->payment_status === PaymentStatusEnum::PAYMENT_SUCCESS->value) {
            $order->update(['status' => OrderStatusEnum::PAID->value]);
        }

        // Gui mail cho nguoi mua thong bao thanh toan thanh cong kem code tham gia
        if ($order->status === 'paid' && $order->reference === null) {
            $join_code = $this->generateRandomCode();

            $order->reference = $join_code;
            $order->save();

            // send email to author
            $reciver_mail = User::where('id', $order->user_id)->first()->email;
            Mail::send('emails.reference_code',
                [
                    'join_code' => $join_code
                ]
                , function ($email) use ($reciver_mail) {
                    $email->to($reciver_mail)->subject('Payment Success, Join Code');
                }
            );
        }

        // Cập nhật status của các post đã thanh toán thành unactive
        if ($order->status === 'paid') {
            $postIdList = Presenter::where('order_id', $order->id)->pluck('post_id')->toArray();
            Post::whereIn('id', $postIdList)->update(['status' => 'unactive']);
        }

        return $order->load('transaction')->toArray();
    }

    public function fetchTransactionReturn($orderId)
    {
        // Lấy thông tin thanh toán từ payment service
        $payment = app(PaymentService::class)->detail($orderId);
        Log::info("Order result", [$payment]);

        // Lưu thông tin thanh toán vào transaction
        $paymentData = $payment['data'];

        // Lấy thông tin order
        $order = Order::where('order_uid', $orderId)->firstOrFail();
        $transaction = optional($order)->transaction;
        if (empty($transaction)) {
            $transaction = new Transaction();
        }

        // Cập nhật thông tin thanh toán vào transaction
        $transactionData = array_merge(
            $transaction->toArray(),
            $paymentData,
            ['order_id' => $order->id]
        );
        $transaction->fill($transactionData)->save();

        // Thanh toan thanh cong => update trang thai order
        if ($transaction->payment_status === PaymentStatusEnum::PAYMENT_SUCCESS->value) {
            $order->update(['status' => OrderStatusEnum::PAID->value]);
        }

        // Cập nhật status của các post đã thanh toán thành unactive
        if ($order->status === 'paid') {
            $postIdList = Presenter::where('order_id', $order->id)->pluck('post_id')->toArray();
            Post::whereIn('id', $postIdList)->update(['status' => 'unactive']);
        }

        return $order->load('transaction')->toArray();

    }
}
