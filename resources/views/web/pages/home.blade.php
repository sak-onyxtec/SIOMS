@extends('web.layouts.master')

@section('content')
    @include('web.layouts.hero', ['title' => 'Welcome to MyStore', 'subtitle' => 'Your One-Stop Online Shop for Quality Products','showButton' => true])
    <!-- =======================
             FEATURES
        ======================= -->
    <section class="py-20 bg-gray-50">
        <div class="container mx-auto px-6">
            <h2 class="text-4xl font-bold text-center mb-4 scroll-fade-in">Why Choose MyStore</h2>
            <p class="text-center text-gray-600 mb-14 scroll-fade-in">Experience the best shopping with our premium features</p>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="bg-white p-8 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 scroll-fade-in border border-gray-100">
                    <div class="w-14 h-14 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-3 text-gray-800">Fast Shipping</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Receive your products quickly with our reliable shipping options.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="bg-white p-8 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 scroll-fade-in border border-gray-100">
                    <div class="w-14 h-14 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-3 text-gray-800">Easy Returns</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Hassle-free returns within 30 days for all products.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="bg-white p-8 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 scroll-fade-in border border-gray-100">
                    <div class="w-14 h-14 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-3 text-gray-800">Secure Payments</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Pay safely using multiple trusted payment methods.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- =======================
             PRODUCT LISTING
        ======================= -->
    <section id="products" class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <h2 class="text-4xl font-bold text-center mb-4 scroll-fade-in">Featured Products</h2>
            <p class="text-center text-gray-600 mb-14 scroll-fade-in">Discover our handpicked selection</p>

            {{-- Livewire Product Listing Component --}}
            <div class="scroll-fade-in">
                <livewire:products.web.feature />
            </div>
        </div>
    </section>

    <!-- =======================
             ABOUT SECTION
        ======================= -->
    <section class="py-20 bg-gray-50">
        <div class="container mx-auto flex flex-col md:flex-row items-center px-6 gap-12">
            <div class="w-full md:w-1/2 scroll-slide-left">
                <img src="https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=600&h=400&fit=crop" class="rounded-xl shadow-xl transform hover:scale-105 transition-transform duration-300">
            </div>

            <div class="w-full md:w-1/2 scroll-slide-right">
                <h2 class="text-4xl font-bold mb-6 text-gray-800">Why Shop With MyStore</h2>
                <p class="text-gray-700 mb-6 leading-relaxed text-lg">
                    We bring you the best products at unbeatable prices. Enjoy fast delivery, excellent customer service,
                    and a secure shopping experience.
                </p>
                <p class="text-gray-700 mb-8 leading-relaxed text-lg">
                    Browse categories, compare products, and enjoy exclusive online deals.
                </p>

                <a href="#products" class="px-8 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-0.5 inline-block">
                    Browse Products
                </a>
            </div>
        </div>
    </section>

    <!-- =======================
             STATS SECTION
        ======================= -->
    <section 
        x-data="{
            productsCount: 0,
            customersCount: 0,
            satisfactionRate: 0,
            animated: false,
            init() {
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting && !this.animated) {
                            this.animated = true;
                            this.animateCounter('productsCount', 10, 2000, 'K+');
                            this.animateCounter('customersCount', 50, 2000, 'K+');
                            this.animatePercentage('satisfactionRate', 99.9, 2000);
                        }
                    });
                }, { threshold: 0.3 });
                
                observer.observe(this.$el);
            },
            animateCounter(property, target, duration, suffix = '') {
                const start = 0;
                const increment = target / (duration / 16);
                let current = start;
                
                const timer = setInterval(() => {
                    current += increment;
                    if (current >= target) {
                        this[property] = target;
                        clearInterval(timer);
                    } else {
                        this[property] = Math.floor(current);
                    }
                }, 16);
            },
            animatePercentage(property, target, duration) {
                const start = 0;
                const increment = target / (duration / 16);
                let current = start;
                
                const timer = setInterval(() => {
                    current += increment;
                    if (current >= target) {
                        this[property] = target;
                        clearInterval(timer);
                    } else {
                        this[property] = parseFloat(current.toFixed(1));
                    }
                }, 16);
            }
        }"
        class="bg-gradient-to-r from-blue-600 to-blue-500 text-white py-20">
        <div class="container mx-auto grid grid-cols-1 md:grid-cols-3 text-center px-6 gap-12">
            <div class="transform hover:scale-110 transition-transform duration-300">
                <h3 class="text-5xl md:text-6xl font-extrabold mb-2">
                    <span x-text="productsCount"></span>K+
                </h3>
                <p class="text-xl text-blue-50">Products Available</p>
            </div>
            <div class="transform hover:scale-110 transition-transform duration-300">
                <h3 class="text-5xl md:text-6xl font-extrabold mb-2">
                    <span x-text="customersCount"></span>K+
                </h3>
                <p class="text-xl text-blue-50">Happy Customers</p>
            </div>
            <div class="transform hover:scale-110 transition-transform duration-300">
                <h3 class="text-5xl md:text-6xl font-extrabold mb-2">
                    <span x-text="satisfactionRate > 0 ? satisfactionRate.toFixed(1) : '0.0'"></span>%
                </h3>
                <p class="text-xl text-blue-50">Satisfaction Rate</p>
            </div>
        </div>
    </section>

    <!-- =======================
             TESTIMONIALS
        ======================= -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <h2 class="text-4xl font-bold text-center mb-4 scroll-fade-in">What Customers Say</h2>
            <p class="text-center text-gray-600 mb-14 scroll-fade-in">Hear from our satisfied customers</p>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 scroll-fade-in border-l-4 border-blue-500">
                    <div class="text-yellow-400 text-2xl mb-4">★★★★★</div>
                    <p class="text-gray-600 italic leading-relaxed mb-4">"Amazing product selection and fast delivery. Highly recommend!"</p>
                    <h4 class="font-bold text-lg text-gray-800">— Ahmed R.</h4>
                </div>
                <div class="bg-white p-8 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 scroll-fade-in border-l-4 border-blue-500">
                    <div class="text-yellow-400 text-2xl mb-4">★★★★★</div>
                    <p class="text-gray-600 italic leading-relaxed mb-4">"Customer support is super helpful and returns are easy."</p>
                    <h4 class="font-bold text-lg text-gray-800">— Sara K.</h4>
                </div>
                <div class="bg-white p-8 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 scroll-fade-in border-l-4 border-blue-500">
                    <div class="text-yellow-400 text-2xl mb-4">★★★★★</div>
                    <p class="text-gray-600 italic leading-relaxed mb-4">"The shopping experience is smooth and secure."</p>
                    <h4 class="font-bold text-lg text-gray-800">— Zeeshan A.</h4>
                </div>
            </div>
        </div>
    </section>

    <!-- =======================
             PRICING / DEALS
        ======================= -->
    <!-- <section class="py-20 bg-gray-50">
        <div class="container mx-auto px-6">
            <h2 class="text-4xl font-bold text-center mb-4 scroll-fade-in">Our Deals</h2>
            <p class="text-center text-gray-600 mb-14 scroll-fade-in">Choose the plan that works best for you</p>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto">
                <div class="p-8 bg-white shadow-md rounded-xl text-center border-2 border-gray-100 hover:border-blue-300 transition-all duration-300 transform hover:-translate-y-2 scroll-fade-in">
                    <h3 class="text-2xl font-bold mb-2 text-gray-800">Starter</h3>
                    <p class="text-gray-600 mb-4">Best for casual shoppers</p>
                    <h4 class="text-4xl font-extrabold mb-6 text-gray-800">PKR 0</h4>
                    <ul class="text-gray-700 space-y-3 mb-8 text-left">
                        <li class="flex items-center gap-2">✔ <span>Access to Products</span></li>
                        <li class="flex items-center gap-2">✔ <span>Discounts on Deals</span></li>
                        <li class="flex items-center gap-2 text-gray-400">✖ <span>Free Shipping</span></li>
                    </ul>
                    <a href="#products" class="px-6 py-3 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition-colors duration-300 inline-block">Start Shopping</a>
                </div>

                <div class="p-8 bg-gradient-to-br from-blue-500 to-blue-600 text-white shadow-2xl rounded-xl text-center transform scale-105 relative scroll-fade-in">
                    <div class="absolute top-0 right-0 bg-yellow-400 text-blue-900 px-4 py-1 rounded-bl-lg rounded-tr-xl text-sm font-bold">Popular</div>
                    <h3 class="text-2xl font-bold mb-2">Premium</h3>
                    <p class="text-blue-100 mb-4">For regular shoppers</p>
                    <h4 class="text-4xl font-extrabold mb-6">PKR 1999 / mo</h4>
                    <ul class="space-y-3 mb-8 text-left">
                        <li class="flex items-center gap-2">✔ <span>Free Shipping</span></li>
                        <li class="flex items-center gap-2">✔ <span>Exclusive Discounts</span></li>
                        <li class="flex items-center gap-2">✔ <span>Priority Support</span></li>
                    </ul>
                    <a href="#products" class="px-6 py-3 bg-white text-blue-700 rounded-lg font-semibold hover:bg-blue-50 transition-colors duration-300 inline-block">Shop Premium</a>
                </div>

                <div class="p-8 bg-white shadow-md rounded-xl text-center border-2 border-gray-100 hover:border-blue-300 transition-all duration-300 transform hover:-translate-y-2 scroll-fade-in">
                    <h3 class="text-2xl font-bold mb-2 text-gray-800">Enterprise</h3>
                    <p class="text-gray-600 mb-4">For bulk orders & businesses</p>
                    <h4 class="text-4xl font-extrabold mb-6 text-gray-800">Contact Us</h4>
                    <ul class="text-gray-700 space-y-3 mb-8 text-left">
                        <li class="flex items-center gap-2">✔ <span>Bulk Discounts</span></li>
                        <li class="flex items-center gap-2">✔ <span>Dedicated Account Manager</span></li>
                        <li class="flex items-center gap-2">✔ <span>Priority Delivery</span></li>
                    </ul>
                    <a href="#contact" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-300 inline-block">Contact Sales</a>
                </div>
            </div>
        </div>
    </section> -->

    <!-- =======================
             FINAL CTA
        ======================= -->
    <section class="bg-gradient-to-r from-blue-600 to-blue-500 text-white py-20 text-center scroll-fade-in">
        <h2 class="text-4xl md:text-5xl font-extrabold mb-6">Start Shopping Today</h2>
        <p class="mb-8 text-lg text-blue-50 max-w-2xl mx-auto">Join thousands of happy customers using MyStore.</p>
        <a href="{{route('products.web')}}" class="px-10 py-4 bg-yellow-300 text-blue-900 rounded-lg font-bold text-lg hover:bg-yellow-200 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:scale-105 inline-block">
            Shop Now
        </a>
    </section>
@endsection
