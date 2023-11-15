<?php

namespace App\Livewire;

use App\Models\Order;
use App\Models\Post;
use App\Models\Presenter;
use App\Models\Transaction;
use App\Models\User;
use App\Services\PaymentService;
use App\Traits\PaymentTrait;
use App\Traits\Ver3PaymentTrait;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class PaymentPortalCancel extends Component
{
    use Ver3PaymentTrait;
    public $returnData;
    public $reference_code;
    public $order_id;
    public $amount;
    public $payment_result;
    protected $isCheckComplete = false;
    public function render()
    {
        return view('livewire.payment-portal-return');
    }



    public function fetch($data)
    {
        $this->fetchTransaction($data);
        dd("Render ra giao thanh toan that bai");
    }

    public function setupViewProperties()
    {
        $order = Order::where('order_uid', $this->returnData['order_id'])->firstOrFail();
        $this->reference_code = $order->reference;
        $this->order_id = $this->returnData['order_id'];
        $this->amount = $this->returnData['amount'];
        $this->payment_result = $this->returnData['result'];
        $this->isCheckComplete = true;
    }

    public function paymentCancel()
    {
        $returnData = request()->post();

        \Log::info("Payment RETURN", $returnData);

        // 1. Log du lieu gui ve
        // 2. Validate data xem co order id hay khong
        // 3 Neu co: fetch transsaction, luu cac thong tin vao db

        if (!empty($returnData['order_id'])) {
            $this->fetch($returnData);
        }

        $this->setupViewProperties();

        if ($this->isCheckComplete) {
            return view('pages.payment-portal.cancel');
        }
    }
}
