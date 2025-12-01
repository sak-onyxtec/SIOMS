@extends('web.layouts.master')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4">
    <div class="max-w-2xl w-full">
        <div class="bg-white rounded-2xl shadow-xl p-8 md:p-12 text-center scroll-fade-in border border-gray-100">
            <!-- Success Icon -->
            <div class="flex justify-center mb-6">
                <div class="w-24 h-24 bg-blue-100 rounded-full flex items-center justify-center">
                    <svg class="w-12 h-12 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
            </div>

            <!-- Heading -->
            <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Order Placed Successfully!</h1>
            
            <p class="text-lg text-gray-600 mb-2">Thank you for your order.</p>
            <p class="text-gray-600 mb-8">An order confirmation has been sent to your email, and you will receive updates shortly.</p>

            @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-lg mb-6">
                    <p class="font-semibold">{{ session('success') }}</p>
                </div>
            @endif

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center mt-8">
                <a href="{{ route('orders.web.listing') }}"
                    class="px-8 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-0.5">
                    View My Orders
                </a>
                <a href="{{ route('products.web') }}"
                    class="px-8 py-3 bg-gray-200 text-gray-800 rounded-lg font-semibold hover:bg-gray-300 transition-all duration-300 transform hover:-translate-y-0.5">
                    Continue Shopping
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

