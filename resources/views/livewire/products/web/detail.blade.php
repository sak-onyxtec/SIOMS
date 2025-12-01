<div class="container mx-auto px-6 py-10">

    <div class="flex flex-col lg:flex-row gap-10">

        {{-- Product Images / Gallery --}}
        <div class="w-full lg:w-1/2 flex flex-col gap-4">

            <div class="rounded-lg shadow-lg overflow-hidden">
                <img src="{{ $product->product_image}}"
                    alt="{{ $product->name }}" class="w-full h-full object-cover rounded-lg">
            </div>

            {{-- Optional: Thumbnails --}}
            @if ($product->gallery_images && count($product->gallery_images))
                <div class="flex gap-2 mt-4 overflow-x-auto">
                    @foreach ($product->gallery_images as $img)
                        <img src="{{ $img }}" alt="{{ $product->name }}"
                            class="w-20 h-20 object-cover rounded-lg cursor-pointer border hover:border-blue-500 transition">
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Product Info --}}
        <div class="w-full lg:w-1/2 flex flex-col gap-4">

            {{-- Title & Category --}}
            <h1 class="text-4xl font-bold">{{ $product->name }}</h1>
            <p class="text-gray-500">{{ $product->category->name ?? 'Uncategorized' }}</p>

            {{-- Price & Stock --}}
            <div class="flex items-center gap-4 mt-2">
                <p class="text-blue-600 font-bold text-3xl">${{ number_format($product->price, 2) }}</p>
                <span
                    class="px-3 py-1 text-sm rounded-full {{ $product->quantity > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ $product->quantity > 0 ? 'In Stock' : 'Out of Stock' }}
                </span>
            </div>

            {{-- Short Description --}}
            @if ($product->short_description)
                <p class="text-gray-700 mt-2">{{ $product->short_description }}</p>
            @endif

            {{-- Quantity Selector --}}
            <div class="flex items-center gap-2 mt-4">
                <button wire:click="decrement"
                    class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded transition disabled:opacity-50"
                    @if ($quantity <= 1) disabled @endif>-</button>

                <input type="text" value="{{ $quantity }}" class="w-16 text-center border rounded font-medium"
                    readonly>

                <button wire:click="increment"
                    class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded transition disabled:opacity-50"
                    @if ($quantity >= $product->quantity) disabled @endif>+</button>
            </div>

            {{-- Add to Cart Button --}}
            <button wire:click="addToCart"
                class="mt-4 px-8 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow hover:bg-blue-700 transition disabled:opacity-50"
                @if ($product->quantity == 0) disabled @endif>
                {{ $product->quantity > 0 ? 'Add to Cart' : 'Out of Stock' }}
            </button>

            {{-- Flash Message --}}
            @if (session()->has('message'))
                <p class="mt-2 text-green-600 font-medium">{{ session('message') }}</p>
            @endif

            {{-- Tabs for Description / Info / Reviews --}}
            <div class="mt-8">
                <ul class="flex border-b">
                    <li class="mr-6">
                        <button class="pb-2 font-semibold border-b-2 border-blue-600">Description</button>
                    </li>
                    <li class="mr-6">
                        <button class="pb-2 font-semibold text-gray-500 hover:text-gray-700">Additional Info</button>
                    </li>
                    <li class="mr-6">
                        <button class="pb-2 font-semibold text-gray-500 hover:text-gray-700">Reviews</button>
                    </li>
                </ul>

                <div class="mt-4">
                    <div class="text-gray-700">
                        {!! $product->description !!}
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- Related Products (Optional Carousel) --}}
    @if ($relatedProducts && $relatedProducts->count())
        <div class="mt-12">
            <h2 class="text-2xl font-bold mb-4">Related Products</h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6">
                @foreach ($relatedProducts as $rel)
                    <a href="{{ route('products.detail.web', ['slug' => $rel->slug]) }}"
                        class="block bg-white shadow rounded-lg overflow-hidden hover:shadow-xl transition">
                        <img src="{{ $rel->product_image }}"
                            alt="{{ $rel->name }}" class="h-40 w-full object-cover">
                        <div class="p-3">
                            <h3 class="text-sm font-semibold">{{ $rel->name }}</h3>
                            <p class="text-blue-600 font-bold">${{ number_format($rel->price, 2) }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

</div>
