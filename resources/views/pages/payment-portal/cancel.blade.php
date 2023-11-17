@extends('layouts.layout')

@section('content')
    <div class="payment-portal-cancel">
        @livewire('payment-portal-cancel', ["returnData" => $returnData])
    </div>
@endsection
