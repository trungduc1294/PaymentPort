<div>
    <div class="payment-success">
        <div class="title">
            <h1>Payment Successful</h1>
            <p>Thank you for your order.</p>
        </div>
        <div class="order-content">
            <h2>This is your order infomation.</h2>
            <div class="order-info-group">
                <span>Joining Code: </span>
                <p>{{$reference_code}}</p>
            </div>
            <div class="order-info-group">
                <span>OrderId: </span>
                <p>{{$order_id}}</p>
            </div>
            <div class="order-info-group">
                <span>Total pay: </span>
                <p>{{ number_format($amount) ?? null}}VND</p>
            </div>
            <div class="order-info-group">
                <span>Payment Status: </span>
                <p>{{$payment_result ?? null}}</p>
            </div>
        </div>
        <div class="payment-more-info">
            <p>Please save your code or you can check again in your email.</p>
            <p>Please contact hotline +84-243.869.3796 if you have any problems.</p>
            <p>If you want to cancel this bill, please contact to hotline.</p>
            <p>Thank you for your order.</p>
        </div>
    </div>
</div>
