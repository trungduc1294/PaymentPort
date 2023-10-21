@extends('layouts.layout')

@section('content')
    <div class="audience_form">
        <h1>Audience Registration Form</h1>
        <form action="{{url("audience-registration")}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="email">Email: </label>
                <input type="email" name="email" id="email" placeholder="Enter your email">
                @if(session('error'))
                    <p class="error">{{session('error')}}</p>
                @endif
            </div>

            <div class="form-group">
                <label for="type_member">Choose your role:</label>
                <select name="type_member" id="type_member">
                    <option value="ADM">Member</option>
                    <option value="AD">Non-member</option>
                    <option value="ADSM">Student-member</option>
                    <option value="ADS">Student-non-member</option>
                    <option value="SVNE">Vietnamese Student</option>
                </select>
            </div>
            <input class="btn" type="submit" value="Confirm">
        </form>
    </div>
@endsection
