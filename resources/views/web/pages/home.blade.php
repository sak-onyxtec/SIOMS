@extends('web.layouts.master')

@section('content')
    @include('web.layouts.hero', [
        'title' => 'Welcome to',
        'subtitle' => 'Your one-stop online shop for smart inventory and order management with SIOMS.',
        'showButton' => true,
    ])
    <!-- =======================
             FEATURES
        ======================= -->
    <section class="py-20 bg-gray-50">
        <div class="container mx-auto px-6">
            <h2 class="text-4xl font-bold text-center mb-4 scroll-fade-in flex items-center justify-center gap-3">
                <i class="fa fa-stars text-blue-500 text-3xl"></i>
                <span>Why Choose SIOMS</span>
            </h2>
            <p class="text-center text-gray-600 mb-14 scroll-fade-in">
                Experience a modern, fast and secure shopping journey powered by our smarter inventory system.
            </p>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="group bg-white p-8 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 scroll-fade-in border border-gray-100">
                    <div class="w-14 h-14 bg-blue-100 rounded-lg flex items-center justify-center mb-4 transform transition-transform duration-300 group-hover:-translate-y-2 group-hover:-rotate-180">
                        <i class="fa fa-truck-fast text-blue-600 text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-3 text-gray-800">Fast Shipping</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Receive your products quickly with our reliable shipping options.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="group bg-white p-8 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 scroll-fade-in border border-gray-100">
                    <div class="w-14 h-14 bg-blue-100 rounded-lg flex items-center justify-center mb-4 transform transition-transform duration-300 group-hover:-translate-y-2 group-hover:-rotate-180">
                        <i class="fa fa-arrow-rotate-left text-blue-600 text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-3 text-gray-800">Easy Returns</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Hassle-free returns within 30 days for all products.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="group bg-white p-8 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 scroll-fade-in border border-gray-100">
                    <div class="w-14 h-14 bg-blue-100 rounded-lg flex items-center justify-center mb-4 transform transition-transform duration-300 group-hover:-translate-y-2 group-hover:-rotate-180">
                        <i class="fa fa-shield-halved text-blue-600 text-2xl"></i>
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
            <h2 class="text-4xl font-bold text-center mb-4 scroll-fade-in flex items-center justify-center gap-3">
                <i class="fa fa-fire text-orange-500 text-3xl"></i>
                <span>Featured Products</span>
            </h2>
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
                <h2 class="text-4xl font-bold mb-6 text-gray-800 flex items-center gap-3">
                    <i class="fa fa-store text-blue-600 text-3xl"></i>
                    <span>Why Shop With SIOMS</span>
                </h2>
                <p class="text-gray-700 mb-6 leading-relaxed text-lg">
                    We bring you the best products at unbeatable prices. Enjoy fast delivery, excellent customer service,
                    and a secure shopping experience.
                </p>
                <p class="text-gray-700 mb-8 leading-relaxed text-lg">
                    Browse categories, compare products, and enjoy exclusive online deals.
                </p>

                <a href="{{route('products.web')}}" class="px-8 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-0.5 inline-block">
                    Browse Products
                </a>
            </div>
        </div>
    </section>

    <!-- =======================
             STATS SECTION
        ======================= -->
    <section id="home-stats" class="bg-gradient-to-r from-blue-600 to-blue-500 text-white py-20">
        <div class="container mx-auto grid grid-cols-1 md:grid-cols-3 text-center px-6 gap-12">
            <div class="scroll-fade-in transform hover:scale-110 transition-transform duration-300">
                <div class="flex justify-center mb-3">
                    <span class="w-12 h-12 rounded-full bg-white/15 flex items-center justify-center">
                        <i class="fa fa-boxes-stacked text-2xl"></i>
                    </span>
                </div>
                <h3 class="text-5xl md:text-6xl font-extrabold mb-1">
                    <span class="stat-number" data-target="10" data-suffix="K+">0</span>
                </h3>
                <p class="text-xl text-blue-50">Products Available</p>
            </div>
            <div class="scroll-fade-in transform hover:scale-110 transition-transform duration-300">
                <div class="flex justify-center mb-3">
                    <span class="w-12 h-12 rounded-full bg-white/15 flex items-center justify-center">
                        <i class="fa fa-users text-2xl"></i>
                    </span>
                </div>
                <h3 class="text-5xl md:text-6xl font-extrabold mb-1">
                    <span class="stat-number" data-target="50" data-suffix="K+">0</span>
                </h3>
                <p class="text-xl text-blue-50">Happy Customers</p>
            </div>
            <div class="scroll-fade-in transform hover:scale-110 transition-transform duration-300">
                <div class="flex justify-center mb-3">
                    <span class="w-12 h-12 rounded-full bg-white/15 flex items-center justify-center">
                        <i class="fa fa-face-smile-beam text-2xl"></i>
                    </span>
                </div>
                <h3 class="text-5xl md:text-6xl font-extrabold mb-1">
                    <span class="stat-number" data-target="99.9" data-suffix="%" data-decimals="1">0</span>
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
            <h2 class="text-4xl font-bold text-center mb-4 scroll-fade-in flex items-center justify-center gap-3">
                <i class="fa fa-comments text-blue-500 text-3xl"></i>
                <span>What Customers Say</span>
            </h2>
            <p class="text-center text-gray-600 mb-10 scroll-fade-in">Hear from our satisfied customers</p>

            {{-- Testimonial Slider --}}
            <div class="max-w-5xl mx-auto relative scroll-fade-in">
                <div id="testimonial-slider" class="overflow-hidden">
                    {{-- Slide 1: 3 testimonials --}}
                    <div class="testimonial-slide">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                            <div class="bg-white p-8 rounded-xl shadow-md border-l-4 border-blue-500">
                                <div class="flex items-center gap-4 mb-4">
                                    <img src="https://i.pravatar.cc/100?img=12" alt="Ahmed R"
                                         class="w-12 h-12 rounded-full object-cover shadow-md">
                                    <div>
                                        <div class="text-yellow-400 text-xl">★★★★★</div>
                                        <h4 class="font-bold text-lg text-gray-800">Ahmed R.</h4>
                                        <p class="text-xs text-gray-400">Regular Customer</p>
                                    </div>
                                </div>
                                <p class="text-gray-600 italic leading-relaxed">
                                    "Amazing product selection and fast delivery. Highly recommend!"
                                </p>
                            </div>

                            <div class="bg-white p-8 rounded-xl shadow-md border-l-4 border-blue-500">
                                <div class="flex items-center gap-4 mb-4">
                                    <img src="https://i.pravatar.cc/100?img=32" alt="Sara K"
                                         class="w-12 h-12 rounded-full object-cover shadow-md">
                                    <div>
                                        <div class="text-yellow-400 text-xl">★★★★★</div>
                                        <h4 class="font-bold text-lg text-gray-800">Sara K.</h4>
                                        <p class="text-xs text-gray-400">Verified Buyer</p>
                                    </div>
                                </div>
                                <p class="text-gray-600 italic leading-relaxed">
                                    "Customer support is super helpful and returns are easy."
                                </p>
                            </div>

                            <div class="bg-white p-8 rounded-xl shadow-md border-l-4 border-blue-500">
                                <div class="flex items-center gap-4 mb-4">
                                    <img src="https://i.pravatar.cc/100?img=47" alt="Zeeshan A"
                                         class="w-12 h-12 rounded-full object-cover shadow-md">
                                    <div>
                                        <div class="text-yellow-400 text-xl">★★★★★</div>
                                        <h4 class="font-bold text-lg text-gray-800">Zeeshan A.</h4>
                                        <p class="text-xs text-gray-400">Long-time User</p>
                                    </div>
                                </div>
                                <p class="text-gray-600 italic leading-relaxed">
                                    "The shopping experience is smooth and secure."
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Slide 2: 3 more testimonials --}}
                    <div class="testimonial-slide hidden">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                            <div class="bg-white p-8 rounded-xl shadow-md border-l-4 border-blue-500">
                                <div class="flex items-center gap-4 mb-4">
                                    <img src="https://i.pravatar.cc/100?img=5" alt="Maria L"
                                         class="w-12 h-12 rounded-full object-cover shadow-md">
                                    <div>
                                        <div class="text-yellow-400 text-xl">★★★★★</div>
                                        <h4 class="font-bold text-lg text-gray-800">Maria L.</h4>
                                        <p class="text-xs text-gray-400">Small Business Owner</p>
                                    </div>
                                </div>
                                <p class="text-gray-600 italic leading-relaxed">
                                    "Inventory tracking is so much easier now. SIOMS saves me hours every week."
                                </p>
                            </div>

                            <div class="bg-white p-8 rounded-xl shadow-md border-l-4 border-blue-500">
                                <div class="flex items-center gap-4 mb-4">
                                    <img src="https://i.pravatar.cc/100?img=21" alt="Omar H"
                                         class="w-12 h-12 rounded-full object-cover shadow-md">
                                    <div>
                                        <div class="text-yellow-400 text-xl">★★★★★</div>
                                        <h4 class="font-bold text-lg text-gray-800">Omar H.</h4>
                                        <p class="text-xs text-gray-400">Frequent Shopper</p>
                                    </div>
                                </div>
                                <p class="text-gray-600 italic leading-relaxed">
                                    "I love how transparent the order statuses are. I always know where my order is."
                                </p>
                            </div>

                            <div class="bg-white p-8 rounded-xl shadow-md border-l-4 border-blue-500">
                                <div class="flex items-center gap-4 mb-4">
                                    <img src="https://i.pravatar.cc/100?img=8" alt="Ayesha S"
                                         class="w-12 h-12 rounded-full object-cover shadow-md">
                                    <div>
                                        <div class="text-yellow-400 text-xl">★★★★★</div>
                                        <h4 class="font-bold text-lg text-gray-800">Ayesha S.</h4>
                                        <p class="text-xs text-gray-400">New Customer</p>
                                    </div>
                                </div>
                                <p class="text-gray-600 italic leading-relaxed">
                                    "Beautiful interface, easy checkout, and quick delivery. Great overall experience."
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Slider controls --}}
                <button id="testimonial-prev"
                        class="absolute left-0 top-1/2 -translate-y-1/2 -translate-x-6 w-10 h-10 rounded-full bg-white shadow-md flex items-center justify-center text-gray-600 hover:bg-gray-100">
                    <i class="fa fa-chevron-left"></i>
                </button>
                <button id="testimonial-next"
                        class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-6 w-10 h-10 rounded-full bg-white shadow-md flex items-center justify-center text-gray-600 hover:bg-gray-100">
                    <i class="fa fa-chevron-right"></i>
                </button>

                {{-- Dots --}}
                <div class="mt-6 flex justify-center gap-2">
                    <button class="testimonial-dot w-2.5 h-2.5 rounded-full bg-blue-500"></button>
                    <button class="testimonial-dot w-2.5 h-2.5 rounded-full bg-blue-200"></button>
                </div>
            </div>
        </div>
    </section>

    <!-- =======================
             HOME FAQ SNIPPET
        ======================= -->
    <section class="py-20 bg-gray-50">
        <div id="home-faq-container" class="container mx-auto px-6 max-w-5xl">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6 mb-8">
                <div>
                    <h2 class="text-3xl md:text-4xl font-bold mb-2 flex items-center gap-3 scroll-fade-in">
                        <i class="fa fa-question-circle text-blue-500 text-3xl"></i>
                        <span>Have Questions?</span>
                    </h2>
                    <p class="text-gray-600 scroll-fade-in">
                        Here are a few quick answers. You can always visit our full FAQ page for more details.
                    </p>
                </div>
                <div class="scroll-fade-in">
                    <a href="{{ route('faq.web') }}"
                       class="inline-flex items-center px-5 py-2.5 bg-white text-blue-600 border border-blue-200 rounded-lg font-semibold shadow-sm hover:bg-blue-50 transition">
                        View All FAQs
                        <i class="fa fa-arrow-right ml-2 text-xs"></i>
                    </a>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-xl divide-y divide-gray-200">
                <details class="p-6 group" open>
                    <summary class="flex justify-between items-center cursor-pointer">
                        <span class="text-sm font-semibold text-gray-800 flex items-center gap-2">
                            <i class="fa fa-truck text-blue-500"></i>
                            How do I track my order?
                        </span>
                        <span class="text-gray-400 group-open:rotate-180 transition-transform">
                            &#9660;
                        </span>
                    </summary>
                    <p class="mt-3 text-sm text-gray-600">
                        After logging in, go to the <strong>“My Orders”</strong> section to view the status and details of your orders.
                    </p>
                </details>

                <details class="p-6 group">
                    <summary class="flex justify-between items-center cursor-pointer">
                        <span class="text-sm font-semibold text-gray-800 flex items-center gap-2">
                            <i class="fa fa-credit-card text-emerald-500"></i>
                            What payment methods are supported?
                        </span>
                        <span class="text-gray-400 group-open:rotate-180 transition-transform">
                            &#9660;
                        </span>
                    </summary>
                    <p class="mt-3 text-sm text-gray-600">
                        We support major debit/credit cards and any additional options displayed at checkout.
                    </p>
                </details>

                <details class="p-6 group">
                    <summary class="flex justify-between items-center cursor-pointer">
                        <span class="text-sm font-semibold text-gray-800 flex items-center gap-2">
                            <i class="fa fa-headset text-purple-500"></i>
                            How can I contact support?
                        </span>
                        <span class="text-gray-400 group-open:rotate-180 transition-transform">
                            &#9660;
                        </span>
                    </summary>
                    <p class="mt-3 text-sm text-gray-600">
                        You can use our <a href="{{ route('contact.web') }}" class="text-blue-600 hover:underline">contact form</a>
                        to reach the SIOMS support team, or email us at <span class="font-mono">support@sioms.test</span>.
                    </p>
                </details>
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
        <p class="mb-8 text-lg text-blue-50 max-w-2xl mx-auto">Join thousands of happy customers using SIOMS.</p>
        <a href="{{route('products.web')}}" class="px-10 py-4 bg-yellow-300 text-blue-900 rounded-lg font-bold text-lg hover:bg-yellow-200 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:scale-105 inline-block">
            Shop Now
        </a>
    </section>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const slides = Array.from(document.querySelectorAll('.testimonial-slide'));
            const dots = Array.from(document.querySelectorAll('.testimonial-dot'));
            const prevBtn = document.getElementById('testimonial-prev');
            const nextBtn = document.getElementById('testimonial-next');
            const slider = document.getElementById('testimonial-slider');
            const homeFaqContainer = document.getElementById('home-faq-container');
            const statsSection = document.getElementById('home-stats');
            const statNumbers = Array.from(document.querySelectorAll('.stat-number'));

            if (!slides.length) return;

            let current = 0;

            function updateSliderHeight() {
                if (!slider) return;
                let maxHeight = 0;
                slides.forEach(slide => {
                    const wasHidden = slide.classList.contains('hidden');
                    if (wasHidden) slide.classList.remove('hidden');
                    const h = slide.offsetHeight;
                    if (h > maxHeight) maxHeight = h;
                    if (wasHidden) slide.classList.add('hidden');
                });
                if (maxHeight > 0) {
                    slider.style.minHeight = maxHeight + 'px';
                }
            }

            function showSlide(index) {
                slides.forEach((slide, i) => {
                    slide.classList.toggle('hidden', i !== index);
                });
                dots.forEach((dot, i) => {
                    dot.classList.toggle('bg-blue-500', i === index);
                    dot.classList.toggle('bg-blue-200', i !== index);
                });
                current = index;
                updateSliderHeight();
            }

            function nextSlide() {
                const next = (current + 1) % slides.length;
                showSlide(next);
            }

            function prevSlide() {
                const prev = (current - 1 + slides.length) % slides.length;
                showSlide(prev);
            }

            if (nextBtn) nextBtn.addEventListener('click', nextSlide);
            if (prevBtn) prevBtn.addEventListener('click', prevSlide);

            dots.forEach((dot, index) => {
                dot.addEventListener('click', () => showSlide(index));
            });

            // Auto-rotate every 6 seconds
            setInterval(nextSlide, 6000);

            // Initialize
            showSlide(0);
            window.addEventListener('resize', updateSliderHeight);

            // Fix height jitter for home FAQ snippet
            if (homeFaqContainer) {
                const faqDetails = Array.from(homeFaqContainer.querySelectorAll('details'));

                function updateHomeFaqHeight() {
                    if (!faqDetails.length) return;
                    const originalStates = faqDetails.map(d => d.open);
                    faqDetails.forEach(d => d.open = true);
                    const h = homeFaqContainer.offsetHeight;
                    faqDetails.forEach((d, i) => d.open = originalStates[i]);
                    if (h > 0) {
                        homeFaqContainer.style.minHeight = h + 'px';
                    }
                }

                faqDetails.forEach(d => d.addEventListener('toggle', updateHomeFaqHeight));
                window.addEventListener('resize', updateHomeFaqHeight);
                updateHomeFaqHeight();
            }

            // Stats counter animation
            if (statsSection && statNumbers.length) {
                let statsAnimated = false;

                const animateStats = () => {
                    if (statsAnimated) return;
                    statsAnimated = true;

                    statNumbers.forEach((el) => {
                        const target = parseFloat(el.dataset.target || '0');
                        const suffix = el.dataset.suffix || '';
                        const decimals = parseInt(el.dataset.decimals || '0', 10);
                        const duration = 1500;
                        const startTime = performance.now();

                        const step = (now) => {
                            const progress = Math.min((now - startTime) / duration, 1);
                            const current = target * progress;
                            el.textContent = current.toFixed(decimals) + suffix;
                            if (progress < 1) {
                                requestAnimationFrame(step);
                            }
                        };

                        requestAnimationFrame(step);
                    });
                };

                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            animateStats();
                            observer.disconnect();
                        }
                    });
                }, { threshold: 0.3 });

                observer.observe(statsSection);
            }
        });
    </script>
@endsection
