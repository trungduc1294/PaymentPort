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

class PaymentPortalReturn extends Component
{
    use Ver3PaymentTrait;
    public $returnData;
    public $reference_code;
    public $order_id;
    public $amount;
    public $payment_result;

    public function mount()
    {
        $this->setupViewProperties();
    }
    public function render()
    {
        dump([
            $this->reference_code,
            $this->order_id,
            $this->amount,
            $this->payment_result,
        ]);
        return view('livewire.payment-portal-return');
    }

    public function setupViewProperties()
    {
        $order = Order::where('order_uid', $this->returnData['order_id'])->firstOrFail();
        $this->reference_code = $order->reference;
        $this->order_id = $this->returnData['order_id'];
        $this->amount = $this->returnData['amount'];
        $this->payment_result = $this->returnData['result'];
    }
}
