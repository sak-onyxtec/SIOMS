    <!-- =======================
         HERO SECTION
    ======================= -->
    <section class="bg-gradient-to-br from-blue-600 via-blue-500 to-blue-700 text-white py-24 relative overflow-hidden">
        <div class="absolute inset-0 bg-black opacity-10"></div>

        {{-- Floating decorative icons --}}
        <div class="pointer-events-none absolute left-6 top-16 hidden md:block">
            <div class="w-16 h-16 rounded-2xl bg-white/10 border border-white/20 flex items-center justify-center shadow-lg animate-float">
                <i class="fa fa-shopping-cart text-2xl text-yellow-200"></i>
            </div>
        </div>
        <div class="pointer-events-none absolute right-10 bottom-10 hidden md:block">
            <div class="w-14 h-14 rounded-xl bg-white/10 border border-white/20 flex items-center justify-center shadow-lg animate-float-alt">
                <i class="fa fa-box-open text-xl text-blue-100"></i>
            </div>
        </div>
        <div class="container mx-auto flex flex-col md:flex-row items-center px-6 relative z-10">
            <!-- Text -->
            <div class="w-full md:w-1/2 scroll-slide-left">
                <h1 class="text-5xl md:text-6xl font-extrabold leading-tight mb-6">
                    {{ $title }}
                    <span class="text-yellow-200 drop-shadow-lg">SIOMS</span>
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
                    <img src="https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=600&h=400&fit=crop"
                         class="rounded-2xl shadow-2xl max-h-80 object-cover relative z-10 animate-float-slow"
                         alt="Hero Image">

                    {{-- Small floating badge on image --}}
                    <div class="absolute -top-12 -right-4 bg-yellow-300 text-blue-900 text-xs font-semibold px-3 py-2 rounded-full shadow-lg animate-float-alt">
                        <i class="fa fa-star mr-1"></i> Smart Inventory
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        @keyframes hero-float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-12px); }
        }

        @keyframes hero-float-alt {
            0% { transform: translateY(0); }
            50% { transform: translateY(10px); }
            100% { transform: translateY(0); }
        }

        .animate-float {
            animation: hero-float 6s ease-in-out infinite;
        }

        .animate-float-alt {
            animation: hero-float-alt 7s ease-in-out infinite;
        }

        .animate-float-slow {
            animation: hero-float 10s ease-in-out infinite;
        }
    </style>
