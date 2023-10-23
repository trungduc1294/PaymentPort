<?php

namespace App\Http\Controllers;



use App\Models\Order;
use App\Models\Price;
use App\Models\User;
use Illuminate\Http\Request;

class AudienceController extends Controller
{
    public function index()
    {

    }

    // Lấy giá tiền theo mã code role, cuủa audience
    public function getPrice($code) {
        $price = Price::where('price_code', $code)->first()->price;
        return $price;
    }

    // lưu thông tin audience đăng ký vào db và lưu vào order
    public function storeUser(Request $request) {
        $data = $request->all();
        $userEmail = $data['email'];
        $type_member = "audience"; // 2 is audience
        $role_id = $data['type_member'];

        $totalPrice = $this->getPrice($role_id);



        //check email exists
        $user = User::where('email', $userEmail)->first();
        if (!$user) {
            // save user
            $newUser = new User();
            $newUser->email = $userEmail;
            $newUser->role_id = $role_id;
            $newUser->user_type = $type_member;
            $newUser->save();

            // save order
            $newOrder = new Order();
            $newOrder->user_id = $newUser->id;
            $newOrder->total_price = $totalPrice;
            $newOrder->status = "unpaid";
            $newOrder->save();

            // đi  đến trang thống kê tiền theo lựa chọn
            return view('pages.audience.audience_purchase_confirm', [
                'order_id' => $newOrder->id,
                'email' => $userEmail,
                'totalPrice' => $totalPrice,
                'type_member' => $type_member
            ]);
        }else {
            $order = Order::where('user_id', $user->id)->first();
            $orderStatus = $order->status;

            // nếu tồn tại nhưng có bill chưa thanh toán thì cho vào để thanh toán
            if ($orderStatus == "unpaid" && $user->user_type == "audience") {
                // đi  đến trang thống kê tiền theo lựa chọn
                return view('pages.audience.audience_purchase_confirm', [
                    'order_id' => $order->id,
                    'email' => $userEmail,
                    'totalPrice' => $totalPrice,
                    'type_member' => $type_member
                ]);
            }
            // nếu trong order unpaid mà là author thì báo lỗi là author
            elseif ($orderStatus == "unpaid" && $user->user_type == "author") {
                return redirect()->back()->with('error', 'You are an author, use For Author form. Unless, use another email.');
            }
            // nếu đã thanh toán thì báo lỗi là trùng email
            else {
                // quay về màn hình form thông tin nếu email trùng
                return redirect()->back()->with('error', 'Email already exists');
            }
        }

    }

    // xóa thông tin order và user đăng ký khi bấm nút cancel ở màn hình thống kê tiền
    public function deleteRegistration($order_id) {
        $order = Order::find($order_id);
        $user = User::find($order->user_id);
        $user->delete();
        $order->delete();
        return redirect()->route('audience-info-form')->with('success', 'Delete success');
    }

    // chuyển đến trang thanh toán
    public function audienceAcceptOrder($order_id) {
        $order = Order::find($order_id);

        // Nếu bấm nút thì verify emailuser
        $user = User::find($order->user_id);
        $user->email_verified_at = now();
        $user->save();

        // neu bam nút trong mail th chuyển đến port thanh toán keèm thông tin
        return view('pages.audience.audience_payment_portal', [
            'order_id' => $order->id,
            'totalPrice' => $order->total_price,
            'email' => $order->user->email
        ]);
    }
}
