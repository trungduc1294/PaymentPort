<?php

namespace App\Livewire;

use App\Models\Order;
use App\Models\Post;
use App\Models\Presenter;
use App\Models\Price;
use App\Models\User;
use Livewire\Component;
use Mail;

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
            $this->step = 'provide_info';
        }
    }



    // STEP3: Dien cac thong tin can thiet va tinh tien (provide_info) ---------------------------------------------------------------
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
    // chưa xử lý trường hợp nếu chọn 2 bài post trở lên thifif khi chọn role của student sẽ báo lỗi vì student chỉ được thanh toán 1 bài post
    public function determineTypeMember ($totalPost, $type_member) {
        if ($type_member === 'ADM' && $totalPost === 1) {
            return "E1";
        }
        if ($type_member === 'ADM' && $totalPost === 2) {
            return "E2";
        }
        if ($type_member === 'ADM' && $totalPost === 3) {
            return "E3";
        }
        if ($type_member === "AD" && $totalPost === 1) {
            return "E4";
        }
        if ($type_member === "AD" && $totalPost === 2) {
            return "E5";
        }
        if ($type_member === "AD" && $totalPost === 3) {
            return "E6";
        }
        if ($type_member === "ADSM" && $totalPost === 1) {
            return "SE1";
        }
        if ($type_member === "ADS" && $totalPost === 1) {
            return "SE2";
        }
    }


    // Tinh phi tham gia cua author (chua tinh extra page)
    public function calAuthorFee () {
        return Price::
        where(
            'price_code',
            $this->determineTypeMember($this->totalPosts, $this->type_member
            ))->first()->price;
    }

    // Tinh phi extra page
    public function calExtraPageFee () {
        return Price::
            where('price_code', 'EP')->first()->price
            * $this->calculateTotalExtraPage();
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

    public function checkout()
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


    // lưu thông tin vào db
    public $order_id;
    public function storeToDB () {
        // store order
        $order = new Order();
        $order->user_id = $this->author->id;
        $order->total_price = $this->total_fee;
        $order->status = 'unpaid';
        $order->save();

        // lưu order_id để lấy ra khi gửi email
        $this->order_id = $order->id;

        // store presenters
        $index = 0;
        foreach ($this->selectedPosts as $post) {
            $presenter = new Presenter();
            $presenter->user_id = $post['author_id'];
            $presenter->post_id = $post['id'];
            $presenter->extra_page = $this->extra_page[$index];
            $presenter->order_id = $order->id;
            $presenter->save();

            $index++;
        }
    }

    // gui email cho author neu bam nut thanh toan
    public function sendEmailToAceptPurchase () {
        Mail::send('emails.author_confirm_purchase',
            [
                'author' => $this->author,
                'total_fee' => $this->total_fee,
                'order_id' => $this->order_id,
                'selectedPosts' => $this->selectedPosts,
            ],
            function ($email) {
//                $email->to($this->author->email)->subject('Bill Payment From RIVF23 Payment Portal');
                $email->to($this->author->email)->subject('Bill Payment From RIVF23 Payment Portal');
            }
        );
        return view('pages.author.please_check_email_page');
    }

    public function purchase() {
        $this->storeToDB();
        $this->sendEmailToAceptPurchase();
        // chuyen sang trang thong bao email da duoc gui
        $this->step = 'email_success';

    }

}
