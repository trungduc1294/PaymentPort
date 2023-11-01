<div class="confirm_code_section loading-container">
    <p>We sent you an email. Let check and enter your verify code here to delete order.</p>
    <input type="text" wire:model="confirm_code">
    <button wire:click="confirmCode">Confirm</button>
    @include('livewire.loading', ['eventTarget' => 'confirmCode'])
</div>
