<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
    @forelse($products as $product)
        <a href="{{ route('products.detail.web', ['slug' => $product->slug]) }}"
           class="bg-white rounded-xl shadow-md overflow-hidden flex flex-col relative transform transition-all duration-300 hover:scale-105 hover:shadow-xl border border-gray-100 group">
            {{-- Out of Stock Badge --}}
            @if ($product->quantity == 0)
                <div class="absolute top-2 left-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded z-10">
                    Out of Stock
                </div>
            @endif

            {{-- Product Image --}}
            <div class="h-48 w-full overflow-hidden">
                <img src="{{ $product->product_image }}" alt="{{ $product->name }}"
                     class="h-full w-full object-cover group-hover:scale-110 transition-transform duration-300">
            </div>

            {{-- Product Info --}}
            <div class="p-4 flex-1 flex flex-col justify-between">
                <div>
                    <h3 class="text-lg font-semibold mb-1 text-gray-800 group-hover:text-blue-600 transition-colors duration-300">{{ $product->name }}</h3>
                    <p class="text-gray-500 text-sm mb-2">
                        {{ optional($product->category)->name ?? 'Uncategorized' }}
                    </p>
                    @if (isset($product->short_description))
                        <p class="text-gray-600 truncate text-sm mb-2 line-clamp-2">
                            {{ Str::limit($product->short_description, 80) }}
                        </p>
                    @endif
                    <p class="text-blue-600 font-bold text-lg">
                        ${{ number_format($product->price, 2) }}
                    </p>
                </div>

                {{-- Add to Cart Button --}}
                <div class="mt-4">
                    <button
                        @if ($product->quantity == 0) disabled @endif
                        wire:click.stop="$emit('addToCart', {
                            id: {{ $product->id }},
                            name: '{{ $product->name }}',
                            price: '{{ $product->price }}',
                            image: '{{ $product->product_image }}'
                        })"
                        class="w-full px-6 py-2 rounded-lg font-semibold transition-all duration-300
                            {{ $product->quantity > 0 ? 'bg-blue-600 text-white hover:bg-blue-700 shadow-md hover:shadow-lg transform hover:-translate-y-0.5' : 'bg-gray-400 text-gray-200 cursor-not-allowed' }}">
                        {{ $product->quantity > 0 ? 'Add to Cart' : 'Unavailable' }}
                    </button>
                </div>
            </div>
        </a>
    @empty
        <div class="col-span-full text-center py-12">
            <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
            </svg>
            <p class="text-gray-500 text-lg">No products found.</p>
        </div>
    @endforelse
</div>
