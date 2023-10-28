<?php

namespace App\Livewire;

use App\Models\Order;
use App\Models\Post;
use App\Models\Presenter;
use App\Models\Price;
use App\Models\User;
use App\Services\OrderService;
use App\Services\PaymentService;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Mail;
use Jantinnerezo\LivewireAlert\LivewireAlert;

/**
 * Step 1:
 * - Step tim kiem
 *     - Sau khi tim kiem va chon bai post, click continue sang step tiep
 * - Step 2: Tinh tien
 *     - Xu ly tinh toan tien va hien thi ngoaif view
 *     - nguoi dung kiem tra thong tin gia ca va nhan nut xac nhan
 * - Step 3: Thanh toan
 *     - Tao 1 record trong bang order de luu giao dich voi trang thai waiting payment
 *     - Tao cac ban ghi tuong ung voi so luong id posts da cho trong bang presenters
 *      - Sau khi xong thi gui email cho nguoi dung confirm
 * - Step 4: Hoan thanh
 *      - Neu nguoi dung click email thanh toan thi kiem tra xem trong he thong:
 *         - bai post da co nguoi thanh toan roi -> bao loi khong th thanh toan
 *             - de toan ven, neu chonj 4 bai ma cos 1 bai da thanh toan thif giao dich ko hoan thanh (cancel)
 *         - bai post chua co nguoi thanh toan -> update trang thai cua order thanh paid
 *      - sau khi click link, hien thi giao dich ket qua thanh toan cho nguoi dung
 */
class Search extends Component
{
    use LivewireAlert;

    // properties
    public $errorMessages;
    public $keyword = '';


    public array $posts = [];
    public $totalPosts;


    public $author;


    public string $step = 'search';

    protected $listeners = [
//        'search' => 'onSearch'
    ];

    public array $selectedPostsId = [];
    public array $selectedPosts = [];

    // STEP1: Xử lý phần tìm kiếm và chọn bài post----------------------------------------------------------------

    public function render()
    {
        return view('livewire.search');
    }

    public function fetch() {
        $posts = Post::query()
            ->with(['author'])
            ->whereIn('status', ['active'])
            ->where('author_name', 'like', '%'.$this->keyword.'%')
            ->get();
        $this->posts = $posts->toArray();
    }

    public function search() {
        $this->fetch();
        // kiểm tra xem sau khi nhập email có tìm thấy bài post nào không
        if (count($this->posts) === 0) {
            $this->errorMessages = 'No post found';
            return false;
        }
        $this->errorMessages = '';
    }


    // xu ly chon bai post
    public function onCheckPost($id)
    {
        if (!empty($this->selectedPostsId[$id])) {
            unset($this->selectedPostsId[$id]);
            return;
        }
        $this->selectedPostsId[$id] = $id;
    }

    // STEP2: Xử lý phần thông tin sau khi chọn các bài posts----------------------------------------------------------------

    // lấy thông tin các bài post theo danh sách id
    public function fetchSelectedPosts() {
        $this->selectedPosts = Post::query()
            ->whereIn('id', $this->selectedPostsId)
            ->get()
            ->toArray();
        $this->totalPosts = count($this->selectedPosts);
    }

    // lọc author, chỉ cho phép chọn các baài post từ 1 tác giả, CHƯA XỬ LÝ PHẦN CHỈ CHO CHỌN TỐI ĐA 3 POST
    public function fetchAuthorInfo() {
        // get author id list from selected posts
        $authorIdList = array_column($this->selectedPosts, 'author_id');

        // if author id list is the same
        if (count(array_unique($authorIdList)) === 1) {
            $authorId = $authorIdList[0];
            $this->author = User::query()->find($authorId);
        }
    }

    public function authorSearchChecker() {
        // Kiem tra da nhap thong tin tim kiem chua
        if (empty($this->keyword)) {
            $this->errorMessages = 'Please enter author email';
            return false;
        } else {
            // kiem tra xem co chon bai post nao khong
            if (count($this->selectedPostsId) === 0) {
                $this->errorMessages = 'Please select at least 1 post';
                return false;
            } else {
                // kiem tra xem co chon qua 3 bai post khong
                if (count($this->selectedPostsId) > 3) {
                    $this->errorMessages = 'Please select maximum 3 posts';
                    return false;
                }

                // kiem tra xem co chon bai post cua nhieu tac gia khac nhau khong
                $authorIdList = array_column($this->selectedPosts, 'author_id');
                if (!(count(array_unique($authorIdList)) === 1)) {
                    $this->errorMessages = 'Please select posts from the same author';
                    return false;
                }
                // Kiểm tra xem có chọn bài post trùng với bài post mà user này đã từng order mà chưa thanh toán (unpaid) không
                $authorId = $authorIdList[0];
                $author = User::query()->find($authorId);
                $authorOrders = Order::query()
                    ->where('user_id', $authorId)
                    ->where('status', 'unpaid')
                    ->get();
                $authorOrderIds = array_column($authorOrders->toArray(), 'id');
                $authorOrderPresenters = Presenter::query()
                    ->whereIn('order_id', $authorOrderIds)
                    ->get();
                $authorOrderPresentersPostIds = array_column($authorOrderPresenters->toArray(), 'post_id');
                $selectedPostsId = array_column($this->selectedPosts, 'id');
                $intersect = array_intersect($authorOrderPresentersPostIds, $selectedPostsId);
                if (count($intersect) > 0) {
                    $this->errorMessages = 'You have already ordered this post put not paid yet. Remove it from the Manage Registration to continue';
                    return false;
                }

            }
        }

        $this->errorMessages = '';
        return true;
    }



    // continue to step 3 khi bấm nút
    public function continue()
    {
        // sử dụng hàm này để lấy được các post đã chọn rồi mới tiến hành kiểm tra được, nếu không fetch thì sẽ không có dữ liệu để kiểm tra
        $this->fetchSelectedPosts();

        // thoa man cac dieu kien moi duoc phep sang buoc tiep theo
        if (!$this->authorSearchChecker()) {
            return;
        } else {
            // nếu thỏa mãn các điều kiện thì sẽ tiến hành lấy thông tin author khi bấm nút và chuyển sang buước tiếp theo
            $this->fetchAuthorInfo();
            $this->step = 'provide_info.blade.php';

            $this->alert('success', 'Choose post successfully!', [
                'position' => 'top-end',
                'timer' => '2000',
                'toast' => true,
                'timerProgressBar' => true,
                'showConfirmButton' => false,
                'onConfirmed' => '',
            ]);
        }
    }



    // STEP3: Dien cac thong tin can thiet va tinh tien (provide_info.blade.php) ---------------------------------------------------------------
    //tạo các wire:model cho các trường cần thiết để lấy dữ liệu
    public $type_member;
    public $extra_page1;
    public $extra_page2;
    public $extra_page3;
    public $extra_page = [];

    // lưu các extra page wire:model vào mảng, nếu không có giá trị thì gán giá trị 0
    public function extrapageConstruct () {
        $this->extra_page = [
            $this->extra_page1 ?? 0,
            $this->extra_page2 ?? 0,
            $this->extra_page3 ?? 0,
        ];
    }

    // hàm tiính tổng số extra page
    public function calculateTotalExtraPage () {
        return array_sum($this->extra_page);
    }

    // xác định price_code của author dựa vào số lượng bài post và loại thành viên
//    public function determineTypeMember ($totalPost, $type_member) {
//        if ($type_member === 'ADM' && $totalPost === 1) {
//            return "E1";
//        }
//        if ($type_member === 'ADM' && $totalPost === 2) {
//            return "E2";
//        }
//        if ($type_member === 'ADM' && $totalPost === 3) {
//            return "E3";
//        }
//        if ($type_member === "AD" && $totalPost === 1) {
//            return "E4";
//        }
//        if ($type_member === "AD" && $totalPost === 2) {
//            return "E5";
//        }
//        if ($type_member === "AD" && $totalPost === 3) {
//            return "E6";
//        }
//        if ($type_member === "ADSM" && $totalPost === 1) {
//            return "SE1";
//        }
//        if ($type_member === "ADS" && $totalPost === 1) {
//            return "SE2";
//        }
//    }


    // Tinh phi tham gia cua author (chua tinh extra page)
    public function calAuthorFee () {
        $priceCode = $this->type_member;
        $totalPost = $this->totalPosts;
        $price = Price::where('price_code', $priceCode)->first()->price;
        return $totalPost * $price;
    }

    // Tinh phi extra page
    public function calExtraPageFee () {
        return Price::
            where('price_code', 'EP')->first()->price * $this->calculateTotalExtraPage();
    }

    // Tinh tong tien
    public function calTotalFee () {
        return $this->calAuthorFee() + $this->calExtraPageFee();
    }


    // continue to step 4 khi bấm nút
    public $atendance_fee;
    public $extra_page_fee;
    public $total_fee;

    // Hàm check nêu chọn 2 bài post trở lên thì không được chọn role là student
    public function checkRoleStudent () {
        if (($this->type_member === 'ADS' || $this->type_member === 'ADSM' || $this->type_member === 'SVNE') && $this->totalPosts > 1) {
            $this->errorMessages = 'Student can only pay for 1 post';
            return false;
        }
        $this->errorMessages = '';
        return true;
    }

    public function showbill()
    {
        // kiểm tra xem đã nhập đủ thông tin chưa
        if (empty($this->type_member)) {
            $this->errorMessages = 'Please select role';
            return;
        } else {
            // kiểm tra xem đã chọn role student chưa
            if (!$this->checkRoleStudent()) {
                return;
            }
        }

        // lưu các extra page wire:model vào mảng, nếu không có giá trị thì gán giá trị 0
        $this->extrapageConstruct();

        // tính toán các giá trị
        $this->atendance_fee = $this->calAuthorFee();
        $this->extra_page_fee = $this->calExtraPageFee();
        $this->total_fee = $this->calTotalFee();

        // chuyển sang step 4
        $this->step = 'checkout';
    }

    // Step 4: đưa dữ liệu ra bill va luu thong tin vao db  (checkout)----------------------------------------------
    public function generateRandomCode() {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $code = '';
        for ($i = 0; $i < 6; $i++) {
            $code .= $characters[rand(0, $charactersLength - 1)];
        }
        return $code;
    }

    public $random_code;

    public function verify() {
        $this->random_code = $this->generateRandomCode();
        $reciver_mail = $this->author->email;
        Mail::send('emails.confirm_code',
            [
                'code' => $this->random_code
            ]
            , function ($email) use ($reciver_mail) {
                $email->to($reciver_mail)->subject('Verify Code');
            }
        );

        $this->step = 'check_code';
        $this->alert('success', 'Mail sent success!', [
            'position' => 'top-end',
            'timer' => '2000',
            'toast' => true,
            'timerProgressBar' => true,
            'showConfirmButton' => false,
            'onConfirmed' => '',
        ]);
    }



    // STEP5: Email code xacs nhaanj -----------------------------------------------------------------------
    public $user_input_code;
    public $order_id;
    public function storeToDB () {

    }
    public function checkCode() {

        try {
            throw_if(
                $this->user_input_code !== $this->random_code,
                new \Exception("Wrong code!")
            );

            // tao du lieu order va presenter
            $orderData = app(OrderService::class)->create([
                // data order
                'author_id' => $this->author->id,
                'total_fee' => $this->total_fee,

                // data presenter
                'selectedPosts' => $this->selectedPosts,
                'extra_page' => $this->extra_page
            ]);

            throw_if(
                (empty($orderData['order'])),
                new \Exception('Fail to create order')
            );
            $order = $orderData['order'];

            // tao transaction o cong thanh toan
            $transaction = app(PaymentService::class)->create($order->id, $this->total_fee);
            Log::info('transaction info', [
                $transaction
            ]);
            throw_if(
                empty($transaction) || (($transaction['code'] ?? 0) !== 200),
                new \Exception('Cannot connect to payment gateway')
            );

            $this->errorMessages = '';
            $this->alert('success', 'Verify Success!', [
                'position' => 'top-end',
                'timer' => '2000',
                'toast' => true,
                'timerProgressBar' => true,
                'showConfirmButton' => false,
                'onConfirmed' => '',
            ]);

            $this->redirect($transaction['data']['url'] ?? 'http://failed.local');
            return;
        } catch (\Exception $exception) {
            $this->errorMessages = $exception->getMessage();
            $this->alert('error', $exception->getMessage(), [
                'position' => 'top-end',
                'timer' => '2000',
                'toast' => true,
                'timerProgressBar' => true,
                'showConfirmButton' => false,
                'onConfirmed' => '',
            ]);
            return;
        }
    }

    // STEP 6: Payment ==============================================================
// wire:model var
//    public $full_name;
//    public $phone_number;
//    public $card_number;
//    public $expiration_date;
//    public $cvv;

//    public function TestAccountCheck() {
//        if (
//            $this->full_name == 'Hoang Ha Trung Duc'
//            && $this->phone_number == '0332764063'
//            && $this->card_number == '0332764063'
//            && $this->expiration_date == '1111'
//            && $this->cvv == '123'
//        ) {
//            return true;
//        } else {
//            return false;
//        }
//    }

//    public function testPaySuccess () {
//        if ($this->TestAccountCheck()) {
//            // update order status
//            $order = Order::query()->find($this->order_id);
//            $order->status = 'paid';
//            $order->save();
//
//            // create a random join code and update in orders table, reference column
//            $join_code = $this->generateRandomCode();
//            $order->reference = $join_code;
//            $order->save();
//
//            // send email to author
//            $reciver_mail = $this->author->email;
//            Mail::send('emails.reference_code',
//                [
//                    'join_code' => $join_code
//                ]
//                , function ($email) use ($reciver_mail) {
//                    $email->to($reciver_mail)->subject('Payment Success, Join Code');
//                }
//            );
//
//            $this->step = 'success';
//        } else {
//            $this->errorMessages = 'Wrong card information';
//        }
//    }


    // STEP 7 Successs ======================================
}
