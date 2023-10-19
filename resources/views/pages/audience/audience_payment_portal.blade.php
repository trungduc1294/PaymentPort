@extends('layouts.layout')

@section('content')
    <div class="audience_payment_portal">
        <h1>Payment Portal</h1>
        <p>Order id: {{$order_id}}</p>
        <p>Email: {{$email}}</p>
        <p>Total Price: {{$totalPrice}}</p>
    </div>
@endsection
