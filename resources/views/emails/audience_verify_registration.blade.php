<p>Email: {{$receiver_email}}</p>
<p>Total Price: {{$total_price}}</p>
<p>Status: {{$order_status}}</p>

{{--Chuyeenr đến cổng thanh toán--}}
<a
    href="{{route('audience.order.accept', ['order_id' => $order_id])}}"
    style="
        background-color: #4CAF50;
        border: none;
        color: white;
        padding: 15px 32px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
    "
>
    Click here to confirm purchase.
</a>
