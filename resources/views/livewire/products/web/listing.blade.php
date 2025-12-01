<div class="container mx-auto px-6 py-10 flex flex-col lg:flex-row gap-6">

    {{-- Sidebar Filters --}}
    <aside class="w-full lg:w-1/4 bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-bold mb-4">Filters</h2>

        {{-- Search --}}
        <div class="mb-6">
            <input type="text" wire:model.debounce.500ms="search" wire:keyup="$set('search', $event.target.value)"
                placeholder="Search products..."
                class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300">
        </div>

        {{-- Categories --}}
        <div class="mb-6">
            <h3 class="font-semibold mb-2">Categories</h3>
            <div class="space-y-2 max-h-64 overflow-y-auto pr-1">
                @foreach ($categories as $cat)
                    <label class="flex items-center justify-between text-sm cursor-pointer">
                        <span class="text-gray-700">{{ $cat->name }} ({{ $cat->products->count() }})</span>
                        <input
                            type="checkbox"
                            wire:model="selectedCategories"
                            wire:change="resetListingPage"
                            value="{{ $cat->id }}"
                            class="form-checkbox rounded text-blue-600 focus:ring-blue-500">
                    </label>
                @endforeach
            </div>
        </div>

        {{-- Price Range --}}
        <div class="mb-6">
            <h3 class="font-semibold mb-2">Price Range</h3>
            <div class="flex gap-2">
                <input type="number" wire:model.debounce.500ms="minPrice"
                    wire:keyup="$set('minPrice', $event.target.value)" placeholder="Min"
                    class="w-1/2 px-3 py-2 border rounded-lg">
                <input type="number" wire:model.debounce.500ms="maxPrice"
                    wire:keyup="$set('maxPrice', $event.target.value)" placeholder="Max"
                    class="w-1/2 px-3 py-2 border rounded-lg">
            </div>
        </div>

        {{-- Low Stock Filter --}}
        <!-- <div class="mb-6">
            <label class="flex items-center space-x-2 cursor-pointer">
                <input type="checkbox" wire:model.live="lowStock" 
                    class="form-checkbox rounded text-blue-600 focus:ring-blue-500">
                <span class="text-sm font-semibold text-gray-700">Low Stock Items (≤5)</span>
            </label>
        </div> -->

        {{-- Clear Filters --}}
        <button wire:click="clearFilters" class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300 w-full font-semibold transition-colors duration-200">Clear
            Filters</button>
    </aside>

    {{-- Products Section --}}
    <div class="w-full lg:w-3/4">

        {{-- View Mode Toggle --}}
        <div class="flex justify-end mb-4 gap-2">
            <button wire:click="setViewMode('grid')"
                class="px-4 py-2 rounded-lg font-semibold transition-all duration-300 {{ $viewMode == 'grid' ? 'bg-blue-600 text-white shadow-md' : 'bg-gray-200 hover:bg-gray-300' }}">
                Grid
            </button>
            <button wire:click="setViewMode('list')"
                class="px-4 py-2 rounded-lg font-semibold transition-all duration-300 {{ $viewMode == 'list' ? 'bg-blue-600 text-white shadow-md' : 'bg-gray-200 hover:bg-gray-300' }}">
                List
            </button>
        </div>

        {{-- Products Grid/List --}}
        <div
            class="{{ $viewMode == 'grid' ? 'grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6' : 'flex flex-col gap-4' }}">
            @forelse($products as $product)
                <a href="{{ route('products.detail.web', ['slug' => $product->slug]) }}">
                    <div
                        class="{{ $viewMode == 'grid' ? 'bg-white rounded-xl shadow-md overflow-hidden flex flex-col relative transform transition-all duration-300 hover:scale-105 hover:shadow-xl border border-gray-100' : 'bg-white rounded-xl shadow-md flex flex-col lg:flex-row items-center overflow-hidden relative transition-all duration-300 hover:shadow-xl p-4 gap-4 border border-gray-100' }}">

                        {{-- Out of Stock Badge --}}
                        @if ($product->quantity == 0)
                            <div
                                class="absolute top-2 left-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded">
                                Out of Stock
                            </div>
                        @endif

                        {{-- Product Image --}}
                        <img src="{{ $product->product_image }}" alt="{{ $product->name }}"
                            class="{{ $viewMode == 'grid' ? 'h-48 w-full object-cover' : 'h-48 w-48 object-cover flex-shrink-0 rounded-lg' }}">

                        {{-- Product Info --}}
                        <div
                            class="{{ $viewMode == 'grid' ? 'p-4 flex-1 flex flex-col justify-between' : 'flex-1 flex flex-col justify-between h-full' }}">
                            <div>
                                <h3 class="text-lg font-semibold mb-1">{{ $product->name }}</h3>
                                <p class="text-gray-500 text-sm mb-2">{{ $product->category->name ?? 'Uncategorized' }}</p>
                                @if (isset($product->short_description))
                                    <p class="text-gray-600 text-sm mb-2">
                                        {{ Str::limit($product->short_description, 100) }}</p>
                                @endif
                                <p class="text-blue-600 font-bold text-lg">${{ number_format($product->price, 2) }}</p>
                            </div>

                            {{-- Add to Cart Button --}}
                            <div class="{{ $viewMode == 'list' ? 'mt-4 lg:mt-0 flex-shrink-0' : 'mt-4' }}">
                                <button @if ($product->quantity == 0) disabled @endif
                                    wire:click="$emit('addToCart', { 
                            id: {{ $product->id }}, 
                            name: '{{ $product->name }}', 
                            price: '{{ $product->price }}', 
                            image: '{{ $product->product_image }}' 
                        })"
                                    class="px-6 py-2 rounded-lg font-semibold transition
                            {{ $product->quantity > 0 ? 'bg-blue-600 text-white hover:bg-blue-700 shadow-md hover:shadow-lg transform hover:-translate-y-0.5' : 'bg-gray-400 text-gray-200 cursor-not-allowed' }}">
                                    {{ $product->quantity > 0 ? 'Add to Cart' : 'Unavailable' }}
                                </button>
                            </div>
                        </div>
                    </div>
                </a>
            @empty
                <p class="col-span-full text-center text-gray-500">No products found.</p>
            @endforelse
        </div>


        {{-- Pagination --}}
        <div class="mt-8 flex justify-center">
            {{ $products->links() }}
        </div>
    </div>
</div>
