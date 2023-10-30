<div class="container">
    @if($step === 'registration-form')
        @include('livewire.partials.audience.registration-form');

    @elseif($step === 'show-bill')
        @include('livewire.partials.audience.show-bill');

    @elseif($step === 'input-code')
        @include('livewire.partials.audience.confirm-code');

    @endif
</div>
