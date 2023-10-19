@extends('layouts.layout')

@section('content')
    <div class="audience_form">
        <form action="{{url("audience-registration")}}" method="post" enctype="multipart/form-data">
            @csrf
            <label for="email">Email: </label>
            <input type="email" name="email" id="email" placeholder="Enter your email">
            @if(session('error'))
                <p class="error">{{session('error')}}</p>
            @endif

            <label for="type_member">Choose your role:</label>
            <select name="type_member" id="type_member">
                <option value="ADM">Member ($400)</option>
                <option value="AD">Non-member ($450)</option>
                <option value="ADSM">Student-member ($300)</option>
                <option value="ADS">Student-non-member ($350)</option>
                <option value="SVNE">Vietnamese Student ($200)</option>
            </select>
            <input type="submit" value="Confirm">
        </form>
    </div>
@endsection
