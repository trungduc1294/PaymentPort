<div class="author_bill loading-container">
    <h2>Payment information.</h2>
    <div class="bill_content">
        <div class="bill_content_group">
            <span>Participation fee. </span>
            <p>{{$atendance_fee}}$</p>
        </div>
        <div class="bill_content_group">
            <span>Extra page fee: </span>
            <p>{{$extra_page_fee}}$</p>
        </div>
        <div class="bill_content_group">
            <span>Total: </span>
            <p>{{$total_fee}}$</p>
        </div>
        <p>To make a payment, please confirm by clicking the 'Verify' button.</p>
    </div>
    <button type="button" wire:click.prevent="verify">Verify</button>
    @include('livewire.loading', ['eventTarget' => 'verify' ])
</div>
