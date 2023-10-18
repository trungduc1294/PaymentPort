<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @yield('style-libraries')
    @yield('style')
</head>
<body>
    @include('partial.header')

    @yield('content')

    @include('partial.footer')

    @yield('script')
</body>
</html>
