@extends('web.layouts.master')

@section('content')
    <div class="container mx-auto px-4 py-12">
        <div class="scroll-fade-in mb-8">
            <h1 class="text-4xl font-bold mb-4 text-center text-gray-800">My Orders</h1>
            <p class="text-center text-gray-600">Track and manage all your orders</p>
        </div>
        <div class="scroll-fade-in">
            <livewire:orders.web.listing />
        </div>
    </div>
@endsection
