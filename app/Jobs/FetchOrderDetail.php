<?php

namespace App\Jobs;

use App\Models\Order;
use App\Services\PaymentService;
use App\Traits\Ver3PaymentTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class FetchOrderDetail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    use Ver3PaymentTrait;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public int $orderId
    )
    {

    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $order = Order::findOrFail($this->orderId);
        $transactionDetail = app(PaymentService::class)->detail($order->order_uid);
        $this->fetchTransaction($transactionDetail);
    }
}
