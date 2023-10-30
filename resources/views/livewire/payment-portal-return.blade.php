<div>
    @if($order)
        <div class="payment-success">
            <div class="title">
                <h1>Payment Successful</h1>
                <p>Thank you for your order.</p>
            </div>
            <div class="order-content">
                <h2>This is your order infomation.</h2>
                <div class="order-info-group">
                    <span>Joining Code: </span>
                    <p>{{$order['reference']}}</p>
                </div>
                <div class="order-info-group">
                    <span>Total pay: </span>
                    <p>{{$order['total_price']}}$</p>
                </div>
                <div class="order-info-group">
                    <span>Total pay: </span>
                    <p>{{$order['transaction']['amount']}}VND</p>
                </div>
                <div class="order-info-group">
                    <span>Payment Status: </span>
                    <p>{{$order['transaction']['payment_desc']}}</p>
                </div>
            </div>
            <div class="payment-more-info">
                <p>Please save your code or you can check again in your email.</p>
                <p>Please contact hotline 0123456789 if you have any problems.</p>
                <p>If you want to cancel this bill, please contact to hotline.</p>
                <p>Thank you for your order.</p>
            </div>
        </div>
    @else
{{--        Có trường hợp côcoongrgr thanh toán hiện thanh toaán thaành công --}}
{{--        nhưng khi trả ve return url lại không có thông tin của order giao dịch, --}}
{{--        và cũng không cập nhật DB nên không biết là có trừ tiền hay chưa, --}}
{{--        làm tạm thông báo giao dịch thất bại--}}
        <div class="payment-fail">
            <div class="title">
                <h1>Payment Fail</h1>
                <p>Sorry, your payment failed.</p>
                <p>Please delete bill in Manage Registration and pay again</p>
            </div>
            <div class="payment-more-info">
                <p>Please contact hotline if you have any problems.</p>
                <p>Thank you for your order.</p>
            </div>
        </div>
    @endif
</div>
