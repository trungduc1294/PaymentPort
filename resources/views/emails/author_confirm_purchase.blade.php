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

