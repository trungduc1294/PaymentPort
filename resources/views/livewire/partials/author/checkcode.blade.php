<div class="check_code">
    <h3>Check email and input verify code here.</h3>
    <div class="code_input">
        <input type="text" wire:model="user_input_code">
        <div class="error_box">
            <span>{{$errorMessages}}</span>
        </div>
        <button wire:click.prevent="checkCode">Submit</button>
    </div>
</div>
