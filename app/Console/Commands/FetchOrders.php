<?php

namespace App\Console\Commands;

use App\Jobs\FetchOrderDetail;
use App\Models\Order;
use App\Services\PaymentService;
use Illuminate\Console\Command;

class FetchOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-orders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Lấy danh sách các order có trạng thái là pending
        // Gọi api lấy thông tin chi tiết của order
        // Cập nhật thông tin thanh toán vào transaction
        // Thanh toan thanh cong => update trang thai order
        // Gui mail cho nguoi mua thong bao thanh toan thanh cong kem code tham gia
        // Cập nhật status của các post đã thanh toán thành unactive

        // Lấy danh sách các order có trạng thái là pending
        $orders = Order::where('status', 'unpaid')->get();
        foreach ($orders as $order) {
            FetchOrderDetail::dispatch($order->order_uid);
        }
    }
}
