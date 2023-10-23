<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        .audience_verify_registration {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 20px;
            width: 300px;
            margin: 0 auto;
            text-align: left;
        }

        .logo {
            color: #3498db; /* Blue color for the logo */
            font-size: 24px;
            margin: 0;
        }

        h2 {
            font-size: 18px;
        }

        h3 {
            font-weight: bold;
        }

        .audience_verify_registration p {
            font-size: 16px;
            margin: 10px 0;
        }

        .audience_verify_registration a {
            display: block;
            padding: 10px 20px;
            background-color: #3498db; /* Blue color for the button */
            color: #fff;
            text-decoration: none;
            margin: 10px 0;
            border-radius: 5px;
            text-align: center;
        }

        .audience_verify_registration a:hover {
            background-color: #2980b9;
        }

        .audience_verify_registration span {
            display: block;
            font-style: italic;
            color: #555;
        }
    </style>


</head>
<body>
    <div class="audience_verify_registration">
        <h1 class="logo">RIVF'23</h1>

        <h2>This is your order infomation. Check again and click under button to redirect to payment port.</h2>

        <div class="info_group">
            <h3>Total Price: </h3>
            <p>{{$total_price}}$</p>
        </div>
        <div class="info_group">
            <h3>Status: </h3>
            <p>{{$order_status}}</p>
        </div>

        {{--Chuyeenr đến cổng thanh toán--}}
        <a
            href="{{route('audience.order.accept', ['order_id' => $order_id])}}"
        >
            Click here to confirm purchase.
        </a>

        <span>Regard!</span>
    </div>

</body>
</html>
