@extends('layouts.layout')

@section('content')
    <div class="audience_purchase_confirm">
        <div class="container">
            <h1>Billing</h1>

            <div class="bill_info">
                <span>Your email:</span> <p> {{$email}}</p>
            </div>

            <div class="bill_info">
                <span>Total Price:</span> <p>{{$totalPrice}}$</p>
            </div>

            <div class="bill_info">
                <span>Role:</span> <p> {{$type_member}}</p>
            </div>


            <div class="button_wrapper">
                <form action="/audience-verify-registration/{{$order_id}}" method="get" enctype="multipart/form-data">
                    @csrf
                    <input class="btn" type="submit" value="Check Out">
                </form>

                <form action="/audience_delete_registration/{{$order_id}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('DELETE')
                    <input class="btn" type="submit" value="Cancel">
                </form>
            </div>
        </div>
    </div>
@endsection
