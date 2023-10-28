<?php

namespace App\Livewire;

use App\Models\Order;
use App\Models\Transaction;
use App\Services\PaymentService;
use App\Traits\PaymentTrait;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class PaymentPortalCancel extends Component
{
    use PaymentTrait;

    public int $orderId;
    public array $order;

    public function mount()
    {
        $this->orderId = request('order_id');
        $this->fetch();
    }

    public function render()
    {
        return view('livewire.payment-portal-cancel');
    }

    public function fetch()
    {
        $this->order = $this->fetchTransaction($this->orderId);
    }
}
