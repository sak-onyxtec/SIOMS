<!-- =======================
     ADVANCED HEADER WITH CART & USER DROPDOWN
======================= -->
<header class="bg-white/90 backdrop-blur shadow-sm sticky top-0 z-50 animate-fade-in">
    <div class="container mx-auto px-6 py-4 flex justify-between items-center">

        <!-- Logo -->
        <a href="{{ route('home.web') }}" class="flex items-center gap-2 hover:scale-105 transition-transform duration-300">
            <img src="{{ asset('images/sioms-logo-horizontal.svg') }}" alt="SIOMS"
                 class="h-8 w-auto">
        </a>

        <!-- Desktop Nav -->
        <nav class="hidden md:flex space-x-8 text-gray-700 font-medium">
            <a href="{{ route('home.web') }}" class="relative group hover:text-blue-600 transition-colors duration-300">
                Home
                <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-500 group-hover:w-full transition-all duration-300"></span>
            </a>
            <a href="{{ route('products.web') }}" class="relative group hover:text-blue-600 transition-colors duration-300">
                Products
                <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-500 group-hover:w-full transition-all duration-300"></span>
            </a>
            <a href="{{ route('contact.web') }}" class="relative group hover:text-blue-600 transition-colors duration-300">
                Contact Us
                <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-500 group-hover:w-full transition-all duration-300"></span>
            </a>
            <a href="{{ route('faq.web') }}" class="relative group hover:text-blue-600 transition-colors duration-300">
                FAQ's
                <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-500 group-hover:w-full transition-all duration-300"></span>
            </a>
            <!-- @auth
                <a href="{{ route('orders.web.listing') }}" class="relative group hover:text-blue-600 transition-colors duration-300">
                    Orders
                    <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-500 group-hover:w-full transition-all duration-300"></span>
                </a>
            @endauth -->
        </nav>

        <!-- Right Side (Auth + Cart) -->
        <div class="hidden md:flex items-center space-x-6">

            <!-- Cart Icon -->
            <livewire:web.header-cart />

            @guest
                <a href="{{ route('login.web') }}" class="text-gray-700 hover:text-blue-600 transition-colors duration-300 font-medium">Login</a>
                <a href="{{ route('register.web') }}"
                    class="bg-blue-600 text-white px-5 py-2.5 rounded-lg hover:bg-blue-700 shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-0.5">
                    Sign Up
                </a>
            @else
                <!-- User Dropdown -->
                <div class="relative" x-data="{ open: false }">
                    <!-- Profile Image Circle -->
                    <button @click="open = !open" class="w-10 h-10 rounded-full overflow-hidden border-2 border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 hover:border-blue-500 transition-all duration-300">
                        <img src="{{ Auth::user()->profile_image ?? 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) }}" alt="Profile Image" class="w-full h-full object-cover">
                    </button>

                    <!-- Dropdown Menu -->
                    <div x-show="open" @click.away="open = false" x-transition
                        class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 z-50 animate-fade-in-up">
                        <a href="{{ route('web.profile') }}"
                            class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Profile</a>
                        <a href="{{ route('orders.web.listing') }}"
                            class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Orders</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">Logout</button>
                        </form>
                    </div>
                </div>
            @endguest
        </div>

        <!-- Mobile Menu Button -->
        <button id="mobileMenuBtn" class="md:hidden text-gray-700 text-3xl">
            ☰
        </button>
    </div>

    <!-- Mobile Menu -->
    <div id="mobileMenu" class="hidden md:hidden bg-white border-t shadow">
        <nav class="flex flex-col p-6 space-y-4 text-gray-700 font-medium">
            <a href="{{ route('home.web') }}" class="hover:text-blue-600 transition-colors duration-300 py-2">Home</a>
            <a href="{{ route('products.web') }}" class="hover:text-blue-600 transition-colors duration-300 py-2">Products</a>
            <!-- @auth
                <a href="{{ route('orders.web.listing') }}" class="hover:text-blue-600 transition-colors duration-300 py-2">Orders</a>
            @endauth -->

            <!-- Mobile Auth Links -->
            @guest
                <a href="{{ route('login.web') }}" class="hover:text-blue-600 transition-colors duration-300 py-2">Login</a>
                <a href="{{ route('register.web') }}"
                   class="bg-blue-600 text-white px-4 py-2.5 rounded-lg text-center shadow-md hover:shadow-lg transition-all duration-300">Sign Up</a>
            @else
                <a href="{{ route('web.profile') }}" class="hover:text-blue-600">Profile</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left hover:text-blue-600">Logout</button>
                </form>
            @endguest
        </nav>
    </div>
</header>

<script>
    document.getElementById('mobileMenuBtn').onclick = () => {
        document.getElementById('mobileMenu').classList.toggle('hidden');
    }
</script>
