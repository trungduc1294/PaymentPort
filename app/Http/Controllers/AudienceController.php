<?php

namespace App\Http\Controllers;



use App\Models\Price;
use App\Models\User;
use Illuminate\Http\Request;

class AudienceController extends Controller
{
    public function index()
    {

    }

    public function getPrice($code) {
        $price = Price::where('price_code', $code)->first()->price;
        return $price;
    }

    public function storeUser(Request $request) {
        $data = $request->all();
        $userEmail = $data['email'];
        $type_member = "audience"; // 2 is audience
        $role_id = $data['type_member'];
        //check email exists
        $user = User::where('email', $userEmail)->first();
        if (!$user) {
            $newUser = new User();
            $newUser->email = $userEmail;
            $newUser->role_id = $role_id;
            $newUser->user_type = $type_member;
            $newUser->save();
            // return to billing page
            return view('pages.audience.audience_purchase_confirm', [
                'email' => $userEmail,
                'totalPrice' => $this->getPrice($role_id),
                'type_member' => $type_member

            ]);
        }else {
            return redirect()->back()->with('error', 'Email already exists');
        }
    }
}
