<!-- =======================
     ADVANCED FOOTER
======================= -->
<footer class="bg-gray-900 text-gray-300 py-14">
    <div class="container mx-auto px-6 grid grid-cols-1 md:grid-cols-4 gap-10">

        <!-- About -->
        <div>
            <div class="mb-4">
                <img src="{{ asset('images/sioms-logo-horizontal-white.svg') }}" alt="SIOMS" class="h-8 w-auto">
            </div>
            <p class="text-gray-400">
                A modern inventory and order management system designed for small & medium businesses.
            </p>
        </div>

        <!-- Quick Links -->
        <div>
            <h3 class="text-lg font-semibold text-white mb-4">Quick Links</h3>
            <ul class="space-y-2">
                <li><a href="{{route('home.web')}}" class="hover:text-white">Home</a></li>
                <li><a href="{{route('products.web')}}" class="hover:text-white">Products</a></li>
                <li><a href="{{route('contact.web')}}" class="hover:text-white">Contact</a></li>
            </ul>
        </div>

        <!-- Support -->
        <div>
            <h3 class="text-lg font-semibold text-white mb-4">Support</h3>
            <ul class="space-y-2">
                <li><a href="{{route('faq.web')}}" class="hover:text-white">FAQ</a></li>
                <li><a href="{{route('privacy.web')}}" class="hover:text-white">Privacy Policy</a></li>
                <li><a href="{{route('terms.web')}}" class="hover:text-white">Terms & Conditions</a></li>
            </ul>
        </div>

        <!-- Social -->
        <div>
            <h3 class="text-lg font-semibold text-white mb-4">Follow Us</h3>
            <div class="flex space-x-4">
                <a href="#" class="hover:text-white text-2xl">🌐</a>
                <a href="#" class="hover:text-white text-2xl">🐦</a>
                <a href="#" class="hover:text-white text-2xl">📘</a>
            </div>
        </div>

    </div>

    <div class="border-t border-gray-700 mt-10 pt-6 text-center text-gray-500">
        © {{ date('Y') }} SIOMS — All Rights Reserved.
    </div>
</footer>
