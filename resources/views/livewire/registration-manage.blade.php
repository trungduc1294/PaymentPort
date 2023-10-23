<div class="registration">
    @if($step === 'search')
        <div class="search_section">
            <div class="error_box">
                <p style="color: red;">{{$errorMessage}}</p>
            </div>

            <div class="email_search_box">
                <input type="text" wire:model="searchValue" placeholder="Search by email..." />
                <button wire:click="search">Search</button>
            </div>

            <div class="list_orders">
                <table>
                    <thead>
                    <tr>
                        <th>Order id</th>
                        <th>Order Status</th>
                        <th>Order Total</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    @if(!empty($orders))
                        <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td>{{$order['id']}}</td>
                                <td>{{$order['status']}}</td>
                                <td>{{$order['total_price']}}</td>
                                <td>
                                    {{-- truyền id của từng order qua wire:submit và gọi đến hàm deleteOrder, truyền id cho hàm đó --}}
                                    <form wire:submit.prevent="deleteOrder({{$order['id']}})">
                                        <button type="submit" onclick="return confirm('Are you sure you want to delete this order?')">Delete</button>
                                    </form>
                                    @if($order['status'] === 'unpaid' || $order['status'] === 'waiting')
                                        <form wire:submit.prevent="showPaymentPort({{$order['id']}})">
                                            <button class="purchase_btn">Purchase</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    @else
                        <tbody>
                        <tr>
                            <td colspan="4">No orders found ...</td>
                        </tr>
                        </tbody>
                    @endif
                </table>
            </div>
        </div>
{{--        STEP 2A -------------------------------------------}}
    @elseif($step === 'confirm_code')
        <div class="confirm_code_section">
                <p>We sent you an email. Let check and enter your verify code here to delete order.</p>
                <input type="text" wire:model="confirm_code">
                <button wire:click="confirmCode">Confirm</button>
        </div>
{{--        STEP 2B -----------------------------------------------------}}
    @elseif($step === 'payment_portal')
        <div class="payment_port">
            <h1>Payment</h1>
            <div class="email_anouncement_content">
                <p>Thank you for your registration. Please fill in infomation to pay yourbill.</p>
            </div>
            <div class="pay_info">
                <div class="pay_info_item">
                    <span>Full name:</span>
                    <input wire:model="full_name" type="text">
                </div>
                <div class="pay_info_item">
                    <span>Phone number:</span>
                    <input wire:model="phone_number" type="text">
                </div>
                <div class="pay_info_item">
                    <span>Card number:</span>
                    <input wire:model="card_number" type="text">
                </div>
                <div class="pay_info_item">
                    <span>Expiration date:</span>
                    <input wire:model="expiration_date" type="text">
                </div>
                <div class="pay_info_item">
                    <span>CVV:</span>
                    <input wire:model="cvv" type="text">
                </div>
                <div class="error_box">
                    <span>{{$errorMessage}}</span>
                </div>
                <button wire:click="confirmPayment">Purchase</button>
            </div>
        </div>
    @elseif($step === 'success')
        <div class="success_section">
            <div class="success_box">
                <p>Thank you for your registration. We sent you an email. Please check your email to get your ticket.</p>
            </div>
        </div>
    @endif
</div>
