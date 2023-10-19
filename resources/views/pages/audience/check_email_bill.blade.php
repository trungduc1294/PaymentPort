@extends('layouts.please_check_email_layout')

@section('remail')
    <a href="/audience-verify-registration/{{$order_id}}" style="font-size: 16px; color: #0073e6; text-decoration: none; font-weight: bold;">Click here to resend email.</a>
@endsection
