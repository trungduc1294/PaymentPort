<div class="verify_by_code">
    <h3>Check your email and fill confirm code here!</h3>
    <div class="verify_code_container">
        <input wire:model="user_code_input" type="text">
        <span>{{$errMessage}}</span>
        <button wire:click.prevent="checkCode">Submit</button>
    </div>
</div>
