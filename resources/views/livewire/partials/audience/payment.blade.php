<div class="payment_port loading-container">
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
            <span>{{$errMessage}}</span>
        </div>
        <button wire:click="testPaySuccess">Purchase</button>
    </div>
    @include('livewire.loading', ['eventTarget' => 'testPaySuccess'])
</div>
