<div class="presenter-page">

    @if($step === 'search')
        @include('livewire.partials.author.search');

    @elseif($step === 'provide_info.blade.php')
        @include('livewire.partials.author.provide_info');

    {{-- STEP 4 Checkout --}}
    @elseif($step === 'checkout')
        @include('livewire.partials.author.checkout');

    {{-- STEP 5 Check code--}}
    @elseif($step === 'check_code')
        @include('livewire.partials.author.checkcode');

    @endif
</div>
