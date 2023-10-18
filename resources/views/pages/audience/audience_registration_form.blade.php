@extends('layouts.layout')

@section('content')
    <div class="audience_form">
        <form action="">
            <label for="email">Email: </label>
            <input type="email" name="email" id="email" placeholder="Enter your email">

            <label for="type_member">Choose your role:</label>
            <select name="type_member" id="type_member">
                <option value="L1">Member ($400)</option>
                <option value="L2">Non-member ($450)</option>
                <option value="SL1">Student-member ($300)</option>
                <option value="SL2">Student-non-member ($350)</option>
                <option value="SVNL">Vietnamese Student ($200)</option>
            </select>
            <input type="submit" value="Confirm">
        </form>
    </div>
@endsection
