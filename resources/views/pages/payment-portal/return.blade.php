@extends('layouts.layout')

@section('content')
    <div class="payment-portal-return">
        @livewire('payment-portal-return', ["returnData" => $returnData])
    </div>
@endsection
