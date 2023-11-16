<?php

namespace App\Livewire;

use App\Models\Price;
use App\Services\OrderService;
use App\Services\PaymentService;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use App\Models\User;
use App\Models\Order;
use Mail;
use RealRashid\SweetAlert\Facades\Alert;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use function PHPUnit\Framework\isJson;

class AudienceRegistration extends Component
{
    use LivewireAlert;

    // string step define
    public $step = 'registration-form';
    public $errMessage = '';

    // WIRE:MODEL var
    public $email;
    public $full_name;
    public $user_code_input;

    // Global var
    public $total_price;

    public function render()
    {
        return view('livewire.audience-registration');
    }

    // STEP 1: REGISTRATION FORM ==============================================================================
    public function checkInfoRegis () {
        // Nếu chưa nập đủ thông tin thì return false
        if ($this->email == null) {
            $this->errMessage = 'Email must not be null';
            return false;
        } else {
            // Check user exits
            $user = User::where('email', $this->email)->first();
//            if ($user && $user->user_type == "author") {
//                $this->errMessage = 'Are you an author? Please use the author \'s form. If not, use a different email.';
//                return false;
//            }
            if ($user && $user->user_type == "audience") {
                $order = Order::where('user_id', $user->id)->first();
                if ($order && $order->status == 'paid') {
                    $this->errMessage = 'This email has already been registered.';
                    return false;
                }
                if ($order && $order->status == 'unpaid') {
                    $this->errMessage = 'Your email has been registered, but payment has not been completed. Please go to the \'Manage Registration\' page to cancel your order first.';
                    return false;
                }
            }
            // Check email format
            if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
                $this->errMessage = 'Email is not valid.';
                return false;
            }
        }
        $this->errMessage = '';
        return true;
    }

    public function getPrice () {
        $price =  Price::where('price_code', 'audience')->first()->price;
        return $price;
    }

    public function handleInfoRegistration () {
        if (!$this->checkInfoRegis()) {
            return;
        } else {
            $this->total_price = $this->getPrice();
            if ($this->total_price == 0) {
                $this->errMessage = 'Let choose your role';
                return;
            } else {
                $this->errMessage = '';
                $this->step = 'show-bill';
            }
        }
    }

    // STEP 2: SHOW BILL ======================================

    // random code a-Z function
    public function generateRandomCode() {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $code = '';
        for ($i = 0; $i < 6; $i++) {
            $code .= $characters[rand(0, $charactersLength - 1)];
        }
        return $code;
    }


    // if click confirm button
    public $random_code;
    public function verify_bill () {
        if (config('maintain.maintain_mode') === true) {
            return redirect()->route('maintain');
        }

        $this->step = 'input-code';
        // send email to user
        $reciver_mail = $this->email;
        $this->random_code = $this->generateRandomCode();
        Log::info("email code", [$this->random_code]);
        Mail::send('emails.confirm_code',
            [
                'code' => $this->random_code
            ]
            , function ($email) use ($reciver_mail) {
                $email->to($reciver_mail)->subject('Payment Verify Code');
            }
        );
    }
    public function cancel_bill () {
        $this->alert('warning', 'Cancel successfully!', [
            'position' => 'top-end',
            'timer' => '2000',
            'toast' => true,
            'timerProgressBar' => true,
            'showConfirmButton' => false,
            'onConfirmed' => '',
        ]);
        $this->step = 'registration-form';
    }

    // STEP 3: INPUT CODE ======================================
    public function checkCode () {
        try {
            throw_if(
                $this->user_code_input != $this->random_code,
                \Exception::class, 'The confirmation code is incorrect.'
            );

            // Luu user vao db
            $user = User::where('email', $this->email)->first();
            if (!$user) {
                $user = new User();
                $user->email = $this->email;
                $user->full_name = $this->full_name;
                $user->user_type = 'audience';
                $user->role_id = 0;
                $user->email_verified_at = now();
                $user->save();
            }

            // Luu order vao db
            $order = Order::where('user_id', $user->id)->first();
            if (!$order) {
                $order = new Order();
                $order->user_id = $user->id;
                $order->total_price = $this->total_price;
                $order->status = 'unpaid';
                $order->save();
            }

            // tao transaction o cong thanh toan
            $transaction = app(PaymentService::class)->create($order->order_uid, $this->total_price);

            Log::info('transaction info after request', [
                $transaction['paymentUrl'],
            ]);
            throw_if(
                empty($transaction),
                new \Exception('Cannot connect to payment gateway')
            );

            $this->errMessage = '';
            $this->alert('success', 'Verify Success!', [
                'position' => 'top-end',
                'timer' => '2000',
                'toast' => true,
                'timerProgressBar' => true,
                'showConfirmButton' => false,
                'onConfirmed' => '',
            ]);

            $this->redirect($transaction['paymentUrl'] ?? 'http://failed.local');
            return;

        } catch (\Exception $exception) {
            $this->errorMessages = $exception->getMessage();
            $this->alert('error', $exception->getMessage(), [
                'position' => 'top-end',
                'timer' => '10000',
                'toast' => true,
                'timerProgressBar' => true,
                'showConfirmButton' => false,
                'onConfirmed' => '',
            ]);
            return;
        }
    }
}

