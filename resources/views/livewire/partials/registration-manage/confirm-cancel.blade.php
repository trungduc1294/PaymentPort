<div class="confirm_code_section loading-container">
    <p style="color: red;">We sent you an email. Let check and enter your verify code here to cancel bill.</p>
    <p style="color: red;">Please contact to our hotline +84-243.869.3796 to know refund method. Money was not be refund online if you click this Cancel Bill button</p>
    <p style="color: red;">If you want to reorder, let do it again.</p>
    <input type="text" wire:model="confirm_code">
    <button wire:click="confirmCanCel">Cancel Bill</button>
    @include('livewire.loading', ['eventTarget' => 'confirmCanCel'])
{{--    loading--}}

</div>
