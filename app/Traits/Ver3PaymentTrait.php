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

trait Ver3PaymentTrait
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

    public function fetchTransaction($data)
    {
        // Lấy thông tin order
        // Cập nhật thông tin thanh toán vào transaction
        // Thanh toan thanh cong => update trang thai order
        // Gui mail cho nguoi mua thong bao thanh toan thanh cong kem code tham gia
        // Cập nhật status của các post đã thanh toán thành unactive

        // Lấy thông tin order
        $order = Order::where('order_uid', $data['order_id'])->firstOrFail();
        // dd($order);
        // Cập nhật thông tin thanh toán vào transaction
        $transaction = optional($order)->transaction;
        if (empty($transaction)) {
            $transaction = new Transaction();
        }
        $transaction->order_id = $order->id;
        $transaction->amount = $data['amount'];
        $transaction->result = $data['result'];
        $transaction->payment_desc = $data['message'];
        $transaction->payment_status = $data['result_code'];
        $transaction->save();

        // Thanh toan thanh cong => update trang thai order
        if ($transaction->payment_status === "200") {
            $order->update(['status' => 'paid']);
        }

        // Gui mail cho nguoi mua thong bao thanh toan thanh cong kem code tham gia
        if ($order->status === 'paid' && $order->reference === null) {
            $join_code = $this->generateRandomCode();

            $order->reference = $join_code;
            $order->save();

            $user_name = User::where('id', $order->user_id)->first()->full_name;

            // send email to author
            $reciver_mail = User::where('id', $order->user_id)->first()->email;
            \Mail::send('emails.reference_code',
                [
                    'join_code' => $join_code,
                    'mail_full_name' => $user_name,
                    'order_id' => $order->order_uid,
                    'amount' => $transaction->amount,
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

            // sau khi thanh toán thành công, xóa những order unpaid có chứa post đã thanh toán
            foreach ($postIdList as $postId) {
                $presenters = Presenter::where('post_id', $postId)->get();
                foreach ($presenters as $presenter) {
                    $unpaidOrder = Order::where('id', $presenter->order_id)
                        ->where('status', 'unpaid')->first();

                    if (!empty($unpaidOrder)) {
                        $unpaidOrder->presenters()->delete();
                        $unpaidOrder->delete();
                    }
                }
            }
        }
    }

    public function fetchTransactionReturn($orderId)
    {

    }
}
