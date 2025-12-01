<div wire:poll.1s="updateCartCount" class="relative">
    <a href="{{ route('cart.web') }}" class="relative inline-flex items-center justify-center group">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
            stroke="currentColor" class="w-7 h-7 text-gray-700 group-hover:text-blue-600 transition-all duration-300 transform group-hover:-translate-y-0.5 group-hover:scale-110">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.293 5.293a1 1 0 00.97 1.207H18m-11-6h12M10 21a1 1 0 110-2 1 1 0 010 2zm8 0a1 1 0 110-2 1 1 0 010 2z" />
        </svg>

        <span
            class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold rounded-full px-2 py-0.5 shadow-lg">
            {{ $cartCount }}
        </span>
    </a>
</div>
