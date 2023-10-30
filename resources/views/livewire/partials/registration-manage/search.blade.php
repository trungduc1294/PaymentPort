<div class="search_section loading-container">
    <span class="info_box">
        Please search by full email, include domain name (e.g. abc@gmail.com) <br>
        If you want to delete an unpaid order, please click on Delete button. Then, you can create your bill again and pay it. <br>
        If you want to cancel a paid order, please contact to hotline: 0123456789. Thank you!
    </span>

    <div class="error_box">
        <p style="color: red;">{{$errorMessage}}</p>
    </div>

    <div class="email_search_box">
        <input type="text" wire:model="searchValue" placeholder="Ex: abc@gmail.com" />
        <button wire:click="search">Search</button>
    </div>

    <div class="list_orders">
        <table>
            <thead>
            <tr>
{{--                <th>Order id</th>--}}
                <th>List of posts</th>
                <th>Order Status</th>
                <th>Order Total</th>
                <th>Actions</th>
            </tr>
            </thead>
            @if(!empty($orders))
                <tbody>
                @foreach($orders as $order)
                    <tr>
{{--                        <td>{{$order['id']}}</td>--}}
                        <td>
                            <?php
                                $postIdList = \App\Models\Presenter::where('order_id', $order['id'])->pluck('post_id')->toArray();
                                $postList = \App\Models\Post::whereIn('id', $postIdList)->get();
                                ?>
                            @foreach($postList as $post)
                                <p>{{$post['title']}}</p>
                            @endforeach
                        </td>
                        <td>{{$order['status']}}</td>
                        <td>{{$order['total_price']}}$</td>
                        <td>
                            {{-- truyền id của từng order qua wire:submit và gọi đến hàm deleteOrder, truyền id cho hàm đó --}}
                            @if($order['status'] === 'unpaid')
                                <form wire:submit.prevent="deleteOrder({{$order['id']}})">
                                    <button class="deleteBtn" type="submit" onclick="return confirm('Are you sure you want to delete this order?')">Delete</button>
                                </form>
                            @endif
                            @if($order['status'] === 'paid')
                                <form wire:submit.prevent="cancelBill({{$order['id']}})">
                                    <button class="cancelBtn" type="submit" onclick="return confirm('You are cancel a paid bill. Please contact to hotline before cancel this bill. Are you sure to cancel?')">Cancel Bill</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            @else
                <tbody>
                <tr>
                    <td colspan="5">No orders found ...</td>
                </tr>
                </tbody>
            @endif
        </table>
    </div>
    @include('livewire.loading', ['eventTarget' => 'deleteOrder'])
    @include('livewire.loading', ['eventTarget' => 'cancelBill'])
</div>
