@extends('layouts.layout')

@section('content')
    <div
        class="please_check_email_layout"
        style="
        background-color: #f2f2f2;
        padding: 140px 80px;
        text-align: center;
        height: 100vh;
        "
    >
        <h1 style="font-size: 24px; color: #333; margin-bottom: 20px;">Please check your email.</h1>
        <p style="font-size: 16px; color: #666;">We have sent you an email to your email address at <a href="https://mail.google.com" style="color: #0073e6; text-decoration: none; font-weight: bold;">Email</a></p>
{{--        <a href="#" style="font-size: 16px; color: #0073e6; text-decoration: none; font-weight: bold;">Click here to resend email.</a>--}}
        @yield('remail')
    </div>

@endsection
