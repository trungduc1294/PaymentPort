<head>
    <style>
        .author_confirm_purchase {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 20px;
            width: 300px;
            margin: 0 auto;
            text-align: left;
        }

        .author_confirm_purchase h1 {
            font-size: 24px;
            margin: 0;
        }

        .author_confirm_purchase p {
            font-size: 16px;
            margin: 10px 0;
        }

        .author_confirm_purchase ul {
            list-style-type: disc;
            margin: 10px 0;
            padding-left: 20px;
        }

        .author_confirm_purchase li {
            margin: 5px 0;
        }

        .author_confirm_purchase a {
            display: inline-block;
            padding: 10px 20px;
            background-color: #3498db; /* Blue color for the button */
            color: #fff;
            text-decoration: none;
            margin: 10px 0;
            border-radius: 5px;
            text-align: center;
        }

        .author_confirm_purchase a:hover {
            background-color: #2980b9;
        }
    </style>
</head>

<body>
    <div class="author_confirm_purchase">
        <h1>Author confirm purchase</h1>

        <p>Hi {{$author->name}},</p>

        <p>You have a bill to purchase:</p>

        <ul>
            @foreach($selectedPosts as $post)
                <li>{{$post['title']}}</li>
            @endforeach
        </ul>

        <p>Please click the link below to confirm purchase:</p>

        {{--<a href="{{route('author.confirm_purchase', ['token' => $token])}}">Confirm purchase</a>--}}

        <a href="#">Confirm purchase</a>

        <p>Regards,</p>

        <p>Admin</p>
    </div>
</body>

