@extends('layouts.layout')

@section('content')
    <div class="author_search">
        <h1>Author Search</h1>

        <!-- Search input -->
        <label for="author-search">Search Author:</label>
        <input type="text" id="author-search" placeholder="Enter author name">
        <button onclick="searchAuthors()">Search</button>

        <!-- Data table -->
        <table>
            <thead>
            <tr>
                <th>POSTID</th>
                <th>Author Name</th>
                <th>Title</th>
                <th>Email</th>
                <th>Payment Status</th>
                <th>Choose to Purchase</th>
            </tr>
            </thead>
            <tbody id="author-data">
            <!-- Sample Data -->
            <tr>
                <td>1</td>
                <td>John Doe</td>
                <td>Sample Title 1</td>
                <td>johndoe@example.com</td>
                <td>Paid</td>
                <td><input type="checkbox"></td>
            </tr>
            <tr>
                <td>2</td>
                <td>Jane Smith</td>
                <td>Sample Title 2</td>
                <td>janesmith@example.com</td>
                <td>Unpaid</td>
                <td><input type="checkbox"></td>
            </tr>
            </tbody>
        </table>
    </div>
@endsection
