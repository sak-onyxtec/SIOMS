@extends('web.layouts.master')

@section('content')
    <div class="container mx-auto px-4 py-12">
        <div class="scroll-fade-in">
            <livewire:orders.web.detail :orderId="$id" />
        </div>
    </div>
@endsection
