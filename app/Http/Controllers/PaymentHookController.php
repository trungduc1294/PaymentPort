<?php

namespace App\Http\Controllers;

use App\Traits\PaymentTrait;
use Illuminate\Support\Facades\Log;
use Mail;

class PaymentHookController extends Controller
{
    use PaymentTrait;




    public function index()
    {
//        {
//            "access_code": "HUST",
//          "amount": "100000",
//          "order_id": "BK1234",
//          "timestamp": "1698419289",
//          "result": "SUCCESS",
//          "checksum": "8c58276d855e2d52c67b93ae5516606b"
//        }

        $data = request()->all();

        Log::info("Payment MOTIFICATION", $data);

        // 1. Log du lieu gui ve
        // 2. Validate data xem co order id hay khong
        // NMeu co: fetch transsaction

        // 3. Neu order status = paid => gui mail
        if (!empty($data['order_id'])) {
            $this->fetchTransaction($data['order_id']);
        }

        return response()->json([
            'status' => 'success'
        ]);
    }
}
