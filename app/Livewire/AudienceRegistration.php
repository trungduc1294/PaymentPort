<?php

namespace App\Livewire;

use App\Models\Price;
use Livewire\Component;
use App\Models\User;
use App\Models\Order;
use Mail;
use RealRashid\SweetAlert\Facades\Alert;

class AudienceRegistration extends Component
{
    // string step define
    public $step = 'registration-form';
    public $errMessage = '';

    // WIRE:MODEL var
    public $email;
    public $role_member;
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
            if ($user && $user->user_type == "author") {
                $this->errMessage = 'You are an author? Use author form. Unless, use another email.';
                return false;
            }
            elseif ($user && $user->user_type == "audience") {
                $order = Order::where('user_id', $user->id)->first();
                if ($order && $order->status == 'paid') {
                    $this->errMessage = 'You have already registered';
                    return false;
                }
                if ($order && $order->status == 'unpaid') {
                    $this->errMessage = 'You have already registered but not paid yet. Go to Manage Registration to delete first.';
                    return false;
                }
            }
        }

        $this->errMessage = '';
        return true;
    }

    public function getPrice () {
        if ($this->role_member == null) {
            return 0;
        }
        return Price::where('price_code', $this->role_member)->first()->price;
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
        $this->step = 'input-code';

        // send email to user
        $reciver_mail = $this->email;
        $this->random_code = $this->generateRandomCode();
        Mail::send('emails.confirm_code',
            [
                'code' => $this->random_code
            ]
            , function ($email) use ($reciver_mail) {
                $email->to($reciver_mail)->subject('Verify Code');
            }
        );
    }
    public function cancel_bill () {
        $this->step = 'registration-form';
    }

    // STEP 3: INPUT CODE ======================================
    public function storeToDb () {
        // Kiểm tra xem user đã tồn tại chưa
        $user = User::where('email', $this->email)->first();
        if (!$user) {
            $user = new User();
            $user->email = $this->email;
            $user->user_type = 'audience';
            $user->role_id = Price::where('price_code', $this->role_member)->first()->id;
            $user->email_verified_at = now();
            $user->save();
        }

        $order = new Order();
        $order->user_id = $user->id;
        $order->total_price = $this->total_price;
        $order->status = 'unpaid';
        $order->save();
    }
    public function checkCode () {
        if ($this->user_code_input == $this->random_code) {
            $this->storeToDb();
            $this->step = 'payment';
        } else {
            $this->errMessage = 'Code is not correct';
        }
    }

    // STEP 4: PAYMENT ======================================
    // wire:model var
    public $full_name;
    public $phone_number;
    public $card_number;
    public $expiration_date;
    public $cvv;

//    public function paymentChecker() {
//        if ($this->full_name == null) {
//            $this->errMessage = 'Full name must not be null';
//            return false;
//        }
//        elseif ($this->phone_number == null) {
//            $this->errMessage = 'Phone number must not be null';
//            return false;
//        }
//        elseif ($this->card_number == null) {
//            $this->errMessage = 'Card number must not be null';
//            return false;
//        }
//        elseif ($this->expiration_date == null) {
//            $this->errMessage = 'Expiration date must not be null';
//            return false;
//        }
//        elseif ($this->cvv == null) {
//            $this->errMessage = 'CVV must not be null';
//            return false;
//        }
//        $this->errMessage = '';
//        return true;
//    }

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

    public function testPaySuccess () {
//        $this->paymentChecker();
        if ($this->TestAccountCheck()) {
            $order = Order::where('user_id', User::where('email', $this->email)->first()->id)->first();
            $order->status = 'paid';
            $order->save();

            // create a random join code and update in orders table, reference column
            $join_code = $this->generateRandomCode();
            $order->reference = $join_code;
            $order->save();

            // send email to user
            $reciver_mail = $this->email;
            Mail::send('emails.reference_code',
                [
                    'join_code' => $join_code
                ]
                , function ($email) use ($reciver_mail) {
                    $email->to($reciver_mail)->subject('Payment success! Join Code');
                }
            );

            $this->errMessage = '';
            $this->step = 'success';
        } else {
            $this->errMessage = 'Payment failed. Please check your information again.';
        }
    }


    // STEP 4.5: REPAY for order which state is unpaid ======================================
}

