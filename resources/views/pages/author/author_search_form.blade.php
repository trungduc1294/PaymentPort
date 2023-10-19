@extends('layouts.layout')

@section('content')
    <div class="author_search">
        <h1>Author Search</h1>

        <!-- Search input -->
        <label for="author-search">Search Author:</label>
        <input type="text" id="author-search" placeholder="Enter author name">
        <button>Search</button>

        <!-- Data table -->
        <table>
            <thead>
            <tr>
                <th>POSTID</th>
                <th>Author</th>
                <th>Title</th>
                <th>Email</th>
                <th>Choose to Purchase</th>
            </tr>
            </thead>
            <tbody id="author-data">
            <!-- Sample Data -->
            @foreach($posts as $post)
                @if($post->status == "active")
                    <tr>
                        <td>{{$post->id}}</td>
                        <td>{{$post->author_name}}</td>
                        <td>{{$post->title}}</td>
                        <td>{{$post->email}}</td>
                        <td><input type="checkbox" name="purchase" value="{{$post->id}}"></td>
                    </tr>
                @endif
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
