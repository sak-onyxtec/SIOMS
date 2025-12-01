<div class="container mx-auto px-6 py-10">
    <h1 class="text-4xl font-bold mb-4 text-center text-gray-800 scroll-fade-in">Shopping Cart</h1>
    <p class="text-center text-gray-600 mb-8 scroll-fade-in">Review your items before checkout</p>

    @if (session()->has('message'))
        <div class="mb-6 bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-lg scroll-fade-in">
            <p class="font-semibold">{{ session('message') }}</p>
        </div>
    @endif

    @if (count($cart) > 0)
        <div class="flex flex-col lg:flex-row gap-6">
            {{-- Cart Items --}}
            <div class="w-full lg:w-3/4 bg-white rounded-xl shadow-md p-6 border border-gray-100 scroll-fade-in">
                <h2 class="text-xl font-bold mb-6 text-gray-800">Cart Items</h2>
                @foreach ($cart as $id => $item)
                    <div class="flex flex-col md:flex-row items-center justify-between border-b border-gray-200 py-6 gap-4 hover:bg-gray-50 transition-colors duration-200 rounded-lg px-2">
                        {{-- Product Image --}}
                        <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}"
                            class="w-24 h-24 object-cover rounded-lg shadow-md">

                        {{-- Product Info --}}
                        <div class="flex-1">
                            <h2 class="text-lg font-semibold text-gray-800 mb-1">{{ $item['name'] }}</h2>
                            <p class="text-blue-600 font-bold text-lg">${{ number_format($item['price'], 2) }}</p>
                        </div>

                        {{-- Quantity Controls --}}
                        <div class="flex items-center gap-2">
                            <button wire:click="decrement({{ $id }})"
                                class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300 transition-colors duration-200 font-semibold disabled:opacity-50 disabled:cursor-not-allowed"
                                @if ($item['quantity'] <= 1) disabled @endif>-</button>
                            <input type="text" value="{{ $item['quantity'] }}"
                                class="w-16 text-center border border-gray-300 rounded-lg font-semibold" readonly>
                            <button wire:click="increment({{ $id }})"
                                class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300 transition-colors duration-200 font-semibold disabled:opacity-50 disabled:cursor-not-allowed"
                                @if ($item['quantity'] >= $item['stock']) disabled @endif>+</button>
                        </div>

                        {{-- Remove --}}
                        <button wire:click="remove({{ $id }})"
                            class="text-red-600 hover:text-red-700 font-semibold hover:underline transition-colors duration-200">
                            Remove
                        </button>
                    </div>
                @endforeach
            </div>

            {{-- Cart Summary --}}
            <div class="w-full lg:w-1/4 bg-white rounded-xl shadow-md p-6 flex flex-col gap-4 border border-gray-100 scroll-fade-in sticky top-24">
                <h2 class="text-xl font-bold mb-4 text-gray-800 border-b pb-4">Order Summary</h2>

                <div class="flex justify-between text-gray-700">
                    <span>Subtotal:</span>
                    <span class="font-semibold">${{ number_format($subtotal, 2) }}</span>
                </div>
                <div class="flex justify-between font-bold text-lg text-gray-800 border-t pt-4">
                    <span>Total:</span>
                    <span class="text-blue-600">${{ number_format($total, 2) }}</span>
                </div>

                @if (Auth::check())
                    <button wire:click="checkout"
                        class="mt-4 w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 font-semibold shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-0.5">
                        Proceed to Checkout
                    </button>
                @else
                    <a href="{{ route('login.web') }}"
                        class="mt-4 w-full inline-block text-center bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 font-semibold shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-0.5">
                        Proceed to Checkout
                    </a>
                @endif

                <button wire:click="clearCart" class="mt-2 w-full bg-gray-200 py-2 rounded-lg hover:bg-gray-300 font-semibold transition-colors duration-200">
                    Clear Cart
                </button>
                
                <a href="{{ route('products.web') }}" class="text-center text-blue-600 hover:text-blue-700 font-semibold hover:underline transition-colors duration-200">
                    Continue Shopping
                </a>
            </div>
        </div>
    @else
        <div class="text-center py-20 scroll-fade-in">
            <svg class="w-24 h-24 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
            </svg>
            <p class="text-2xl font-semibold text-gray-500 mb-2">Your cart is empty</p>
            <p class="text-gray-600 mb-6">Start adding items to your cart</p>
            <a href="{{ route('products.web') }}" class="inline-block px-8 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-0.5">
                Continue Shopping
            </a>
        </div>
    @endif
</div>
