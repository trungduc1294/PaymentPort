<?php

namespace App\Livewire;

use App\Models\Post;
use App\Models\Presenter;
use App\Services\PaymentService;
use Illuminate\Support\Facades\Log;
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
            $this->errorMessage = 'No matching email found. Please check again.';
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
            function ($email) use ($user_email) {
                $email->to($user_email)->subject('Confimation Code');
            }
        );

    }

    // DELETE BUTTON CLICK CALL THIS FUNCTION
    public function deleteOrder ($id) {
        // $id = order_id (not user_id
        $this->delete_order_id = $id;
        $this->sendCodeEmail();
        $this->step = 'confirm_code';
    }

    // CANCEL BILL CLICK CALL THIS FUNCTION
    public function cancelBill ($id) {
        $this->delete_order_id = $id;
        $this->sendCodeEmail();
        $this->step = 'confirm_cancel';
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
            $this->alert('success', 'Delete successfully!', [
                'position' => 'top-end',
                'timer' => '2000',
                'toast' => true,
                'timerProgressBar' => true,
                'showConfirmButton' => false,
                'onConfirmed' => '',
            ]);

            $this->step = 'search';
        } else {
            $this->errorMessage = 'Your verification code is incorrect. Please try again.';
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

    // CONFIRM TO CANCEL BILL CLICK CALL THIS FUNCTION
    // Buoc 1: so sanh code
    // Buoc 2: xoa order
    // Buoc 3: xoa presenter
    // Buoc 3: cap nhat trang thai post ve active de hien thi dang ky lai
    public function confirmCanCel() {
        if ($this->confirm_code == $this->random_code) {

            $order = Order::find($this->delete_order_id);

            $presenters = Presenter::where('order_id', $order->id)->get();

            // update status of post to active and delete presenter
            if ($presenters) {
                foreach ($presenters as $presenter) {
                    $post = Post::find($presenter->post_id);
                    $post->status = 'active';
                    $post->save();

                    $presenter->delete();
                }
            }

            // delete order
            $order->delete();

            // call search function to update list order
            $this->search();
            $this->errorMessage = '';
            $this->alert('success', 'Cancel successfully!', [
                'position' => 'top-end',
                'timer' => '2000',
                'toast' => true,
                'timerProgressBar' => true,
                'showConfirmButton' => false,
                'onConfirmed' => '',
            ]);

            $this->step = 'search';
        } else {
            $this->errorMessage = 'Your verification code is incorrect. Please try again.';
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
