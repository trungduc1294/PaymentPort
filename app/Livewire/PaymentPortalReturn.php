<?php

namespace App\Livewire;

use App\Models\Order;
use App\Models\Transaction;
use App\Services\PaymentService;
use App\Traits\PaymentTrait;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class PaymentPortalReturn extends Component
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
        return view('livewire.payment-portal-return');
    }

    public function fetch()
    {
        $this->order = $this->fetchTransactionReturn($this->orderId);
    }

}
