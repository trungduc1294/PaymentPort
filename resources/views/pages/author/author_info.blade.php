@extends('layouts.layout')

@section('content')
    <div class="author_info">
        <h3>Hello $name</h3>
        <form action="{{url('/author-accept-order')}}" method="" enctype="multipart/form-data">
            @csrf
            <div class="post_section">
                <div class="post_section_group">
                    <label for="extra-page">$post[0]->title</label>
                    <input name="extra-page" id="extra-page" type="text">
                </div>
                <div class="post_section_group">
                    <label for="extra-page">$post[1]->title</label>
                    <input name="extra-page" id="extra-page" type="text">
                </div>
            </div>
            <div class="author_section">
                <div class="info_group">
                    <span>Your name: </span>
                    <p>$author_name</p>
                </div>
                <div class="info_group">
                    <span>Your email: </span>
                    <p>$author_email</p>
                </div>
                <div class="info_group">
                    <span>Number of newpaper: </span>
                    <p>$count_newpaper</p>
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
            </div>

            <input type="submit" value="Continue">
        </form>
    </div>
@endsection
