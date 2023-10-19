@extends('layouts.layout')

@section('content')
    <div class="audience_purchase_confirm">
        <h1>Audience Purchase confirm.</h1>
        <p>Email: {{$email}}</p>
        <p>Total Price: {{$totalPrice}}</p>
        <p>User type: {{$type_member}}</p>

        <form action="/audience-verify-registration/{{$order_id}}" method="get" enctype="multipart/form-data">
            @csrf
            <input type="submit" value="Check Out">
        </form>

        <form action="/audience_delete_registration/{{$order_id}}" method="post" enctype="multipart/form-data">
            @csrf
            @method('DELETE')
            <input type="submit" value="Cancel">
        </form>
    </div>
@endsection
