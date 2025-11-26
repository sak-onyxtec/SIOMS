<div class="p-4">

    {{-- Search --}}
    <div class="mb-4 flex justify-end">
        <input type="text" wire:model.debounce.300ms="search" placeholder="Search products..."
            class="border rounded px-4 py-2 w-64 focus:outline-none focus:ring focus:border-blue-300">
    </div>

    {{-- Products Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse ($products as $product)
            <a href="{{ route('products.detail', $product->id) }}" wire:key="product-{{ $product->id }}">
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden hover:shadow-lg transition duration-200">
                    
                    {{-- Product Image --}}
                    <div class="h-48 bg-gray-100 flex items-center justify-center">
                        @if ($product->product_image)
                            <img src="{{ $product->product_image }}" alt="{{ $product->name }}"
                                class="h-full object-contain">
                        @else
                            <span class="text-gray-400">No Image</span>
                        @endif
                    </div>

                    {{-- Product Info --}}
                    <div class="p-4">
                        <h3 class="font-semibold text-lg">{{ $product->name }}</h3>
                        <p class="text-sm text-gray-500">SKU: {{ $product->sku }}</p>
                        <p class="text-sm text-gray-500">Category: {{ $product->category ?? '-' }}</p>
                        <p class="text-base font-semibold mt-2">${{ number_format($product->price, 2) }}</p>
                        <p class="text-sm text-gray-500">Qty: {{ $product->quantity }}</p>
                    </div>

                </div>
            </a>
        @empty
            <p class="col-span-full text-center text-gray-500">No products found.</p>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="mt-6">
        {{ $products->links() }}
    </div>
</div>
