<div class="registration">
    @if($step === 'search')
        @include('livewire.partials.registration-manage.search');

{{-- STEP 2A -------------------------------------------}}
    @elseif($step === 'confirm_code')
        @include('livewire.partials.registration-manage.confirm-code');

    @elseif($step === 'confirm_cancel')
        @include('livewire.partials.registration-manage.confirm-cancel');

{{--STEP 2B -----------------------------------------------------}}
{{--    @elseif($step === 'payment_portal')--}}
{{--        @include('livewire.partials.registration-manage.payment-port');--}}

{{--    @elseif($step === 'success')--}}
{{--        @include('livewire.partials.registration-manage.success');--}}

    @endif
</div>
