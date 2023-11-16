<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Post;
use App\Models\Presenter;
use App\Models\Transaction;
use App\Models\User;
use App\Traits\Ver3PaymentTrait;

class ReturnController extends Controller
{
    use Ver3PaymentTrait;
    public function index()
    {
    }

    public function success() {
        $returnData = request()->post();

        $this->fetchTransaction($returnData);

        \Log::info("Payment RETURN", $returnData);

        // 1. Log du lieu gui ve
        // 2. Validate data xem co order id hay khong
        // 3 Neu co: fetch transsaction, luu cac thong tin vao db


        return view('pages.payment-portal.return', [
            'returnData' => $returnData
        ]);
    }
}
