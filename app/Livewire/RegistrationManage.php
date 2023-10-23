<?php

namespace App\Livewire;

use App\Models\Presenter;
use Request;
use App\Models\Order;
use App\Models\User;
use Livewire\Component;
use Mail;
use function Laravel\Prompts\alert;
use function Laravel\Prompts\confirm;

class RegistrationManage extends Component
{
    public $errorMessage;
    public string $step = 'search';

    public function render()
    {
        return view('livewire.registration-manage');
    }

    //Step1: search user by email
    public $searchValue;

    public $listOrders;
    public $orders = [];
    public function search()
    {
        // get user have email = $searchValue
        $user = User::where('email', $this->searchValue)->first();

        // get list order have user_id = $user_id
        if ($user) {
            $this->listOrders = Order::where('user_id', $user->id)->get();
            $this->orders = $this->listOrders->toArray();
        } else {
            $this->errorMessage = 'Không tìm thấy email nào phù hợp. Hãy kiểm tra lại.';
            return;
        }
        $this->errorMessage = '';
    }


    //Step2: delete order and send email have a code to confirm delete ------------------------------------------------
    public $delete_order_id;
    public $random_code;
    public $confirm_code; //user input confirm code
    public function generateRandomCode() {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $code = '';
        for ($i = 0; $i < 6; $i++) {
            $code .= $characters[rand(0, $charactersLength - 1)];
        }
        return $code;
    }

    public function sendCodeEmail() {
        $user_email = $this->searchValue;
        $this->random_code = $this->generateRandomCode();
        Mail::send('emails.confirm_code',
            [
                'code' => $this->random_code,
            ],
            function ($message) use ($user_email) {
                $message->to($user_email);
                $message->subject('Confimation Code');
            }
        );

    }

    public function deleteOrder ($id) {
        // $id = order_id (not user_id
        $this->delete_order_id = $id;
        $this->sendCodeEmail();
        $this->step = 'confirm_code';
    }

    // Step3: compare code by input at view manage-registration.input_confirm_code
    public function confirmCode() {
        if ($this->confirm_code == $this->random_code) {

            $order = Order::find($this->delete_order_id);

            // get all presenters of order and delete
            $presenters = Presenter::where('order_id', $order->id)->get();
            if ($presenters) {
                foreach ($presenters as $presenter) {
                    $presenter->delete();
                }
            }

            // delete order
            $order->delete();

            // call search function to update list order
            $this->search();
            $this->errorMessage = '';
            $this->step = 'search';
        } else {
            $this->errorMessage = 'Mã xác nhận không đúng';
            $this->step = 'search';
        }
    }
}
