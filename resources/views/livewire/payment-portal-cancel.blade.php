<div>
    <div>
        <div class="payment-fail">
            <div class="title">
                <h1>Payment Fail</h1>
                <p>Your payment was be fail.</p>
            </div>
            <div class="order-content">
                <h2>This is your order infomation.</h2>
                <div class="order-info-group">
                    <span>Total pay: </span>
                    <p>{{$order['total_price']}}$</p>
                </div>
                @if(!empty($order['transaction']))
                    <div class="order-info-group">
                        <span>Total pay: </span>
                        <p>{{$order['transaction']['amount'] ?? null}}VND</p>
                    </div>
                    <div class="order-info-group">
                        <span>Payment Status: </span>
                        <p>{{$order['transaction']['payment_desc'] ?? null}}</p>
                    </div>
                @endif
            </div>
            <div class="payment-more-info">
                <p>If you want to pay your bill again. Please delete your "unpaid" bill in Manage Registration first.</p>
                <p>Then you can create a bill and pay again</p>
                <p>Please contact hotline 0123456789 if you have any problems.</p>
                <p>Thank you.</p>
                <a href="/registration-manage">Redirect to Manage Registration</a>
            </div>
        </div>
    </div>
</div>
