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
use Jantinnerezo\LivewireAlert\LivewireAlert;

class RegistrationManage extends Component
{
    use LivewireAlert;

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

            // check empty list
            if (count($this->orders) == 0) {
                $this->alert('warning', 'There are no orders!', [
                    'position' => 'top-end',
                    'timer' => '2000',
                    'toast' => true,
                    'timerProgressBar' => true,
                    'showConfirmButton' => false,
                    'onConfirmed' => '',
                ]);
                return;
            }
        } else {
            $this->errorMessage = 'Không tìm thấy email nào phù hợp. Hãy kiểm tra lại.';
            $this->alert('error', 'Your email is inappropriate!', [
                'position' => 'top-end',
                'timer' => '2000',
                'toast' => true,
                'timerProgressBar' => true,
                'showConfirmButton' => false,
                'onConfirmed' => '',
            ]);
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

    // Step 2B: show payment portal ----------------------------------------------------------------------------
    public function showPaymentPort($id) {
        $this->step = 'payment_portal';
    }

    // Step 3B: confirm payment portal ----------------------------------------------------------------------------
    public $full_name;
    public $phone_number;
    public $card_number;
    public $expiration_date;
    public $cvv;

    public function TestAccountCheck() {
        if (
            $this->full_name == 'Hoang Ha Trung Duc'
            && $this->phone_number == '0332764063'
            && $this->card_number == '0332764063'
            && $this->expiration_date == '1111'
            && $this->cvv == '123'
        ) {
            return true;
        } else {
            return false;
        }
    }

    public function confirmPayment() {
        if ($this->TestAccountCheck()) {
            $order = Order::where('user_id', User::where('email', $this->searchValue)->first()->id)->first();
            $order->status = 'paid';
            $order->save();

            // create a random join code and update in orders table, reference column
            $join_code = $this->generateRandomCode();
            $order->reference = $join_code;
            $order->save();

            // send email to user
            $reciver_mail = $this->searchValue;
            Mail::send('emails.reference_code',
                [
                    'join_code' => $join_code
                ]
                , function ($email) use ($reciver_mail) {
                    $email->to($reciver_mail)->subject('Payment success! Join Code');
                }
            );

            $this->errorMessage = '';
            $this->step = 'success';
        } else {
            $this->errorMessage = 'Payment failed. Please check your information again.';
            $this->alert('error', 'Payment fail!', [
                'position' => 'top-end',
                'timer' => '2000',
                'toast' => true,
                'timerProgressBar' => true,
                'showConfirmButton' => false,
                'onConfirmed' => '',
            ]);
        }
    }

    // Step3: CONFIRM CODE TO DELETE ORDER----------------------------------
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
            $this->alert('success', 'Verify successfully!', [
                'position' => 'top-end',
                'timer' => '2000',
                'toast' => true,
                'timerProgressBar' => true,
                'showConfirmButton' => false,
                'onConfirmed' => '',
            ]);

            $this->step = 'search';
        } else {
            $this->errorMessage = 'Mã xác nhận không đúng';
            $this->alert('error', 'Wrong code. Again!', [
                'position' => 'top-end',
                'timer' => '2000',
                'toast' => true,
                'timerProgressBar' => true,
                'showConfirmButton' => false,
                'onConfirmed' => '',
            ]);
            $this->step = 'search';
        }
    }
}
