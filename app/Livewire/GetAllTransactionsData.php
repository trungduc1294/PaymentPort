<?php

namespace App\Livewire;

use App\Models\Order;
use App\Traits\Ver3PaymentTrait;
use Livewire\Component;
use App\Services\PaymentService;

class GetAllTransactionsData extends Component
{
    use Ver3PaymentTrait;
    public function render()
    {
        return view('livewire.get-all-transactions-data');
    }

    public function getAllTransactionsData()
    {
        // Buoc 1: Lay ra tat ca cac order co trong database
        // Buoc 2: Lay ra danh sach order_uid tu danh sach order
        // buoc 3: foreach order_uid, goi ham detail trong PaymentService de lay ra thong tin chi tiet cua order
        // Buoc 4: Neu detail tra ve thanh cong, goi fetchTransaction trong Ver3PaymentTrait de cap nhat thong tin transaction
        // Buoc 5: Thong bao thanh cong

        // Buoc 1: Lay ra tat ca cac order co trong database
        $orders = Order::all();
        // Buoc 2: Lay ra danh sach order_uid tu danh sach order
        $order_uids = $orders->pluck('order_uid')->toArray();
        // buoc 3: foreach order_uid, goi ham detail trong PaymentService de lay ra thong tin chi tiet cua order
        foreach ($order_uids as $order_uid) {
            $paymentService = new PaymentService();
            $detail = $paymentService->detail($order_uid);
            // Buoc 4: Neu detail tra ve thanh cong, goi fetchTransaction trong Ver3PaymentTrait de cap nhat thong tin transaction
            if ($detail['code'] === 200) {
                $this->fetchTransaction($detail['data']);
            }
        }
        // Buoc 5: Thong bao thanh cong
        session()->flash('message', 'Lấy dữ liệu thành công');
    }
}
