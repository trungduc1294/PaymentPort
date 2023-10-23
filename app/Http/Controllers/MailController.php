<?php

namespace App\Http\Controllers;
use App\Models\User;
use Mail;
use App\Models\Order;

class MailController extends Controller
{
    public function index()
    {

    }

    // tesst
    public function testMail() {
        $name = 'Trung Duc';
        Mail::send('emails.test',
            compact('name')
            , function ($email) use ($name) {
                $email->to('trungduc.1294@gmail.com', $name)->subject('Test Mail');
            }
        );
    }
}
