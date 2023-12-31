<div class="check_code loading-container">
    <h3>Please enter the verification code sent to your email</h3>
    <h4 style="color: red; margin-bottom: 10px;"><bold>!IMPORTANT: After successful payment, please wait for 10 seconds for the payment gateway to redirect you back to our ICHST website to complete the transaction (do not exit in the meantime).</bold></h4>
    <div class="code_input">
        <input type="text" wire:model="user_input_code" placeholder="Enter the verification code here, for example: abcXYZ.">
        <div class="error_box">
            <span>{{$errorMessages}}</span>
        </div>
        <button wire:click.prevent="checkCode">Proceed to the payment portal.</button>
    </div>
    @include('livewire.loading', ['eventTarget' => 'checkCode' ])
</div>
