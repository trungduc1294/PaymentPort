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
