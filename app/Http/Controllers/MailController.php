<?php

namespace App\Http\Controllers;
use App\Models\User;
use Mail;
use App\Models\Order;

class MailController extends Controller
{
    public function index()
    {

    }

    // tesst
    public function testMail() {
        $name = 'Trung Duc';
        Mail::send('emails.test',
            compact('name')
            , function ($email) use ($name) {
                $email->to('trungduc.1294@gmail.com', $name)->subject('Test Mail');
            }
        );
    }

    public function audienceVerifyRegistration($order_id) {
        $order = Order::find($order_id);
        $user_id = $order->user_id;
        $user = User::find($user_id);

        $receiver_email = $user->email;
        $total_price = $order->total_price;
        $order_status = $order->status;

        // gửi email yêu câầu thanh toán đến người nhận audience
        Mail::send('emails.audience_verify_registration',
            compact(
                'order_id',
                'user_id',
                'receiver_email',
                'total_price',
                'order_status'
            ),
            function ($email) use ($receiver_email) {
                $email->to($receiver_email)->subject('Bill Payment From RIVF23 Payment Portal');
            }
        );

        // trả về màn hình thông báo đã gửi email, hãy check email của bạn
        return view('pages.audience.check_email_bill', compact('order_id'));
    }
}
