@php
    $lightboxImages = [];
    if ($product->product_image) {
        $lightboxImages[] = $product->product_image;
    }
    if ($product->images && $product->images->count()) {
        foreach ($product->images as $img) {
            $lightboxImages[] = $img->image_url;
        }
    }
@endphp

<div x-data="{
        tab: 'description',
        zoomOpen: false,
        images: @js($lightboxImages),
        currentIndex: 0,
        get activeImage() { return this.images[this.currentIndex] || '' },
        get zoomSrc() { return this.images[this.currentIndex] || '' },
        // Change active image only (no lightbox)
        openAt(index) {
            this.currentIndex = index;
        },
        next() {
            if (!this.images.length) return;
            this.currentIndex = (this.currentIndex + 1) % this.images.length;
        },
        prev() {
            if (!this.images.length) return;
            this.currentIndex = (this.currentIndex - 1 + this.images.length) % this.images.length;
        }
     }">

<div class="container mx-auto px-6 py-10">

    <div class="flex flex-col lg:flex-row gap-10">

        {{-- Product Images / Gallery --}}
        <div class="w-full lg:w-1/2 flex flex-col gap-4">

            {{-- Main image with hover zoom + click to open modal --}}
            <div
                class="rounded-lg shadow-lg overflow-hidden group cursor-zoom-in"
                @click="zoomOpen = true">
                <img
                    :src="activeImage"
                    alt="{{ $product->name }}"
                    class="w-full h-full object-cover rounded-lg transform transition-transform duration-300 group-hover:scale-110">
            </div>

            {{-- Thumbnails (main image + additional images) --}}
            <div class="flex gap-2 mt-4 overflow-x-auto">
                {{-- Main image thumbnail --}}
                <img
                    src="{{ $product->product_image }}"
                    alt="{{ $product->name }} main image"
                    class="w-20 h-20 object-cover rounded-lg border-2 cursor-pointer transition"
                    :class="activeImage === '{{ $product->product_image }}'
                        ? 'border-blue-500 ring-2 ring-blue-300'
                        : 'border-gray-200 hover:border-blue-400'"
                    @click="openAt(0)">

                {{-- Additional images --}}
                @if ($product->images && $product->images->count())
                    @foreach ($product->images as $image)
                        <img
                            src="{{ $image->image_url }}"
                            alt="{{ $product->name }}"
                            class="w-20 h-20 object-cover rounded-lg border-2 cursor-pointer transition"
                            :class="activeImage === '{{ $image->image_url }}'
                                ? 'border-blue-500 ring-2 ring-blue-300'
                                : 'border-gray-200 hover:border-blue-400'"
                            @click="openAt({{ $loop->index + 1 }})">
                    @endforeach
                @endif
            </div>
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
            <div class="flex items-center gap-3 mt-4">
                <span class="text-sm font-medium text-gray-700">Quantity</span>

                <button
                    wire:click="decrement"
                    class="w-9 h-9 flex items-center justify-center rounded-full border border-gray-300 bg-gray-100 hover:bg-gray-200 text-gray-700 text-lg font-semibold transition disabled:opacity-40 disabled:cursor-not-allowed"
                    @if ($quantity <= 1) disabled @endif
                    aria-label="Decrease quantity">
                    -
                </button>

                <div class="min-w-[3rem] text-center font-semibold text-gray-800">
                    {{ $quantity }}
                </div>

                <button
                    wire:click="increment"
                    class="w-9 h-9 flex items-center justify-center rounded-full border border-gray-300 bg-gray-100 hover:bg-gray-200 text-gray-700 text-lg font-semibold transition disabled:opacity-40 disabled:cursor-not-allowed"
                    @if ($quantity >= $product->quantity) disabled @endif
                    aria-label="Increase quantity">
                    +
                </button>
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

            {{-- Tabs: Description & Images --}}
            <div class="mt-8">
                <ul class="flex border-b">
                    <li class="mr-6">
                        <button
                            @click="tab = 'description'"
                            :class="tab === 'description' ? 'pb-2 font-semibold border-b-2 border-blue-600 text-blue-600' : 'pb-2 font-semibold text-gray-500 hover:text-gray-700 border-b-2 border-transparent'">
                            Description
                        </button>
                    </li>
                </ul>

                <div class="mt-4">
                    {{-- Description tab --}}
                    <div x-show="tab === 'description'" x-cloak class="text-gray-700 leading-relaxed">
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

{{-- Zoom / Lightbox Modal - Teleported to body for full-page overlay --}}
<template x-teleport="body">
    <div
        x-show="zoomOpen"
        x-cloak
        class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/80 backdrop-blur-sm"
        @keydown.escape.window="zoomOpen = false"
        @click.self="zoomOpen = false">
        <div class="relative max-w-5xl w-full px-4">
            <button
                class="absolute -top-3 -right-3 bg-white text-gray-700 rounded-full w-8 h-8 flex items-center justify-center shadow hover:bg-gray-100 z-10"
                @click="zoomOpen = false">
                ✕
            </button>
            <div class="bg-white rounded-lg overflow-hidden shadow-2xl relative flex items-center justify-center">
                <button
                    type="button"
                    class="hidden sm:flex absolute left-2 sm:left-4 z-10 items-center justify-center w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-white/80 text-gray-700 hover:bg-white shadow"
                    @click.stop="prev()">
                    ‹
                </button>
                <img :src="zoomSrc" alt="Zoomed image" class="w-full max-h-[80vh] object-contain bg-black">
                <button
                    type="button"
                    class="hidden sm:flex absolute right-2 sm:right-4 z-10 items-center justify-center w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-white/80 text-gray-700 hover:bg-white shadow"
                    @click.stop="next()">
                    ›
                </button>
            </div>
        </div>
    </div>
</template>

</div>
