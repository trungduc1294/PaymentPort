<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Presenter;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderService
{
    public function create (array $params) {
        /*
         * Buowcs 1: tao order
         * Buoc 2: Goi payment de lay url redirect
         * Buoc 3: Tao transaction
         * Buoc 4: Return url redirect
         * */

        try {
            DB::beginTransaction();
            $order = Order::create([
                'user_id' => $params['author_id'],
                'total_price' => $params['total_fee'],
                'status' => 'unpaid'
            ]);


            foreach ($params['selectedPosts'] as $index=>$post) {
                $presenter = Presenter::create([
                    'user_id' => $params['author_id'],
                    'post_id' => $post['id'],
                    'extra_page' => $params['extra_page'][$index] ?? 0,
                    'order_id' => $order->id,
                ]);
            }

            DB::commit();
            return [
                "order" => $order,
            ];
        }catch (\Exception $exception) {
            Log::info("create order fail", [$exception->getMessage(), func_get_args()]);
            DB::rollBack();
            return null;
        }
    }
}
