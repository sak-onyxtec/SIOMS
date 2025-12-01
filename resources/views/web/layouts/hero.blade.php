    <!-- =======================
         HERO SECTION
    ======================= -->
    <section class="bg-gradient-to-br from-blue-600 via-blue-500 to-blue-700 text-white py-24 relative overflow-hidden">
        <div class="absolute inset-0 bg-black opacity-10"></div>
        <div class="container mx-auto flex flex-col md:flex-row items-center px-6 relative z-10">
            <!-- Text -->
            <div class="w-full md:w-1/2 scroll-slide-left">
                <h1 class="text-5xl md:text-6xl font-extrabold leading-tight mb-6">
                    {{ $title }}
                    <span class="text-yellow-200 drop-shadow-lg">MyStore</span>
                </h1>

                <p class="text-lg md:text-xl text-blue-50 mb-8 leading-relaxed">
                    {{ $subtitle }}
                </p>

                @if ($showButton)
                    <a href="{{ route('products.web') }}"
                        class="bg-yellow-300 text-blue-900 px-8 py-4 rounded-lg font-bold shadow-xl hover:bg-yellow-200 transition-all duration-300 transform hover:scale-105 inline-flex items-center gap-2">
                        Shop Now
                        <span class="text-xl">→</span>
                    </a>
                @endif
            </div>

            <!-- Hero Image -->
            <div class="w-full md:w-1/2 mt-10 md:mt-0 flex justify-center scroll-slide-right">
                <div class="relative">
                    <div class="absolute inset-0 bg-gradient-to-r from-blue-400 to-blue-600 rounded-2xl transform rotate-6 opacity-20"></div>
                    <img src="https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=600&h=400&fit=crop" class="rounded-2xl shadow-2xl max-h-80 object-cover relative z-10 transform hover:scale-105 transition-transform duration-300" alt="Hero Image">
                </div>
            </div>
        </div>
    </section>
