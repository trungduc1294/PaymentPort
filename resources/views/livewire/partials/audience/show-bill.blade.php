<div class="show_bill">
    <h1>Billing</h1>
    <div class="bill_container">
        <div class="bill_info">
            <span>Your email:</span> <p>{{$email}}</p>
        </div>
        <div class="bill_info">
            <span>Total Price:</span> <p>{{$total_price}}$</p>
        </div>
        <div class="bill_info">
            <span>Role:</span> <p>{{$role_member}}</p>
        </div>
    </div>
    <div class="button_wrapper">
        <button wire:click.prevent="verify_bill" >Confirm</button>
        <button wire:click.prevent="cancel_bill">Cancel</button>
    </div>
</div>
