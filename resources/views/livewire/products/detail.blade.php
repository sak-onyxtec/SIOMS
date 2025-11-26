<div class="max-w-4xl mx-auto py-12">
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden flex flex-col md:flex-row">

        {{-- Product Image --}}
        <div class="md:w-1/2 h-96 bg-gray-100 flex items-center justify-center">
            @if ($product->product_image)
                <img src="{{ $product->product_image }}" alt="{{ $product->name }}" class="h-full object-contain">
            @else
                <span class="text-gray-400">No Image</span>
            @endif
        </div>

        {{-- Product Info --}}
        <div class="md:w-1/2 p-6 flex flex-col justify-between">
            <div>
                <h2 class="text-2xl font-bold mb-2">{{ $product->name }}</h2>
                <p class="text-gray-500 mb-2">SKU: {{ $product->sku }}</p>
                <p class="text-gray-500 mb-2">Category: {{ $product->category ?? '-' }}</p>
                <p class="text-xl font-semibold mb-4">${{ number_format($product->price, 2) }}</p>
                <p class="text-gray-500 mb-4">Available Qty: {{ $product->quantity }}</p>
            </div>

            {{-- Quantity & Add to Cart --}}
            <div class="flex items-center gap-4 mt-4">
                <div class="flex items-center border rounded">
                    <button wire:click="decrement" class="px-3 py-2 bg-gray-200 hover:bg-gray-300"
                        @if ($quantity <= 1) disabled @endif>-</button>

                    <input type="text" value="{{ $quantity }}" class="w-12 text-center border-none" readonly>

                    <button wire:click="increment" class="px-3 py-2 bg-gray-200 hover:bg-gray-300"
                        @if ($quantity >= $product->quantity) disabled @endif>+</button>
                </div>


                <button wire:click="addToCart" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Add to Cart
                </button>
            </div>

            @if (session()->has('message'))
                <p class="text-green-500 mt-3">{{ session('message') }}</p>
            @endif
        </div>
    </div>
    @if($similarProducts->count() > 0)
        <div class="mt-12">
            <h3 class="text-xl font-bold mb-4">Similar Products</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                @foreach($similarProducts as $item)
                    <div class="bg-white dark:bg-gray-700 shadow rounded p-4 flex flex-col items-center">
                        @if($item->product_image)
                            <img src="{{ $item->product_image }}" alt="{{ $item->name }}" class="h-32 object-contain mb-2">
                        @else
                            <span class="text-gray-400 mb-2">No Image</span>
                        @endif
    
                        <h4 class="font-semibold text-center">{{ $item->name }}</h4>
                        <p class="text-gray-500">${{ number_format($item->price, 2) }}</p>
    
                        <a href="{{ route('products.detail', $item->id) }}" 
                           class="mt-2 px-4 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">
                           View
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>


