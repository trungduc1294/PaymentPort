@extends('layouts.layout')

@section('content')
    <div class="audience_purchase_confirm">
        <h1>Audience Purchase confirm.</h1>
        <p>Email: {{$email}}</p>
        <p>Total Price: {{$totalPrice}}</p>
        <p>User type: {{$type_member}}</p>

        <form action="" method="post" enctype="multipart/form-data">
            <input type="submit" value="Check Out">
        </form>
    </div>
@endsection
