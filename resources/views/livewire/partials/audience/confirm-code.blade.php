<div class="verify_by_code loading-container">
    <h3>Check your email and enter the verification code.</h3>
    <div class="verify_code_container">
        <input wire:model="user_code_input" type="text" placeholder="Enter the verification code here. Ex: abcXYz">
        <span>{{$errMessage}}</span>
        <button wire:click.prevent="checkCode">Submit</button>
    </div>
    @include('livewire.loading', ['eventTarget' => 'checkCode'])
</div>
