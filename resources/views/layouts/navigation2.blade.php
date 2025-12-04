<!-- Sidebar + Main Layout Wrapper -->
<div
    x-data="{
        sidebarOpen: JSON.parse(localStorage.getItem('sidebarOpen') ?? 'true'),
        toggleSidebar() {
            this.sidebarOpen = !this.sidebarOpen;
            localStorage.setItem('sidebarOpen', this.sidebarOpen);
        }
    }"
    x-cloak
    class="min-h-screen bg-gray-100 dark:bg-gray-900 flex">

    <!-- Sidebar (fixed) -->
    <aside
        class="fixed inset-y-0 left-0 bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 flex flex-col z-40"
        :class="sidebarOpen ? 'w-64' : 'w-20'">
        <!-- Brand -->
        <div class="py-4 px-6 border-b border-gray-200 dark:border-gray-700 flex items-center">
            <a href="{{ route('dashboard') }}" class="flex items-center space-x-2 no-underline">
                {{-- Full logo when sidebar is open --}}
                <img src="{{ asset('images/sioms-logo-horizontal.svg') }}"
                     alt="SIOMS"
                     class="h-11 w-auto"
                     x-show="sidebarOpen"
                     x-cloak>

                {{-- Compact favicon when sidebar is closed --}}
                <img src="{{ asset('favicon.svg') }}"
                     alt="SIOMS"
                     class="h-11 w-auto"
                     x-show="!sidebarOpen"
                     x-cloak>
            </a>
        </div>

        <!-- Navigation -->
        <nav class="mt-3 flex-1 flex flex-col space-y-1 px-2">
            <!-- Dashboard -->
            <a href="{{ route('dashboard') }}"
               :title="sidebarOpen ? '' : 'Dashboard'"
               class="flex items-center px-3 py-2 rounded-lg text-md font-medium no-underline
                      {{ request()->routeIs('dashboard') ? 'bg-blue-600 text-white shadow-sm' : 'text-gray-600 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-gray-700 hover:text-blue-600' }} transition-all duration-150">
                <i class="fa fa-home w-5 text-center"></i>
                <span class="ml-2 whitespace-nowrap" x-show="sidebarOpen" x-cloak>Dashboard</span>
            </a>

            @can('view-products')
            <!-- Products -->
            <a href="{{ route('product.index') }}"
               :title="sidebarOpen ? '' : 'Products'"
               class="flex items-center px-3 py-2 rounded-lg text-md font-medium no-underline
                      {{ request()->routeIs('product.index') || request()->routeIs('product.create') || request()->routeIs('product.view') || request()->routeIs('product.edit') ? 'bg-blue-600 text-white shadow-sm' : 'text-gray-600 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-gray-700 hover:text-blue-600' }} transition-all duration-150">
                <i class="fa fa-shopping-cart w-5 text-center"></i>
                <span class="ml-2 whitespace-nowrap" x-show="sidebarOpen" x-cloak>Products</span>
            </a>
            <a href="{{ route('category.index') }}"
               :title="sidebarOpen ? '' : 'Categories'"
               class="flex items-center px-3 py-2 rounded-lg text-md font-medium no-underline
                      {{ request()->routeIs('category.index') || request()->routeIs('category.create') || request()->routeIs('category.edit') ? 'bg-blue-600 text-white shadow-sm' : 'text-gray-600 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-gray-700 hover:text-blue-600' }} transition-all duration-150">
                <i class="fa fa-list-alt w-5 text-center"></i>
                <span class="ml-2 whitespace-nowrap" x-show="sidebarOpen" x-cloak>Categories</span>
            </a>
            @endcan

            @can('manage-staffs')
                <a href="{{ route('staff.index') }}"
                   :title="sidebarOpen ? '' : 'Staffs'"
                   class="flex items-center px-3 py-2 rounded-lg text-md font-medium no-underline
                          {{ request()->routeIs('staff.index') || request()->routeIs('staff.create') || request()->routeIs('staff.edit') ? 'bg-blue-600 text-white shadow-sm' : 'text-gray-600 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-gray-700 hover:text-blue-600' }} transition-all duration-150">
                    <i class="fa fa-users w-5 text-center"></i>
                    <span class="ml-2 whitespace-nowrap" x-show="sidebarOpen" x-cloak>Staffs</span>
                </a>

                @endcan
                @can('manage-customers')
                <a href="{{ route('customers.index') }}"
                   :title="sidebarOpen ? '' : 'Customers'"
                   class="flex items-center px-3 py-2 rounded-lg text-md font-medium no-underline
                          {{ request()->routeIs('customers.index') || request()->routeis('customers.view') ? 'bg-blue-600 text-white shadow-sm' : 'text-gray-600 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-gray-700 hover:text-blue-600' }} transition-all duration-150">
                    <i class="fa fa-user w-5 text-center"></i>
                    <span class="ml-2 whitespace-nowrap" x-show="sidebarOpen" x-cloak>Customers</span>
                </a>

                @endcan
            @can('manage-permissions')
                <a href="{{ route('roles.index') }}"
                   :title="sidebarOpen ? '' : 'Roles & Permissions'"
                   class="flex items-center px-3 py-2 rounded-lg text-md font-medium no-underline
                          {{ request()->routeIs('roles.index') || request()->routeIs('roles.permissions') ? 'bg-blue-600 text-white shadow-sm' : 'text-gray-600 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-gray-700 hover:text-blue-600' }} transition-all duration-150">
                    <i class="fa fa-key w-5 text-center"></i>
                    <span class="ml-2 whitespace-nowrap" x-show="sidebarOpen" x-cloak>Roles & Permissions</span>
                </a>
            @endcan

            @can('manage-inventory')
                <a href="{{ route('inventory.index') }}"
                   :title="sidebarOpen ? '' : 'Inventory'"
                   class="flex items-center px-3 py-2 rounded-lg text-md font-medium no-underline
                          {{ request()->routeIs('inventory.index') ? 'bg-blue-600 text-white shadow-sm' : 'text-gray-600 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-gray-700 hover:text-blue-600' }} transition-all duration-150">
                    <i class="fa fa-box w-5 text-center"></i>
                    <span class="ml-2 whitespace-nowrap" x-show="sidebarOpen" x-cloak>Inventory</span>
                </a>
            @endcan

            @can('manage-orders')
                <a href="{{ route('orders.index') }}"
                   :title="sidebarOpen ? '' : 'Orders'"
                   class="flex items-center px-3 py-2 rounded-lg text-md font-medium no-underline
                          {{ request()->routeIs('orders.index') || request()->routeIs('orders.detail') ? 'bg-blue-600 text-white shadow-sm' : 'text-gray-600 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-gray-700 hover:text-blue-600' }} transition-all duration-150">
                    <i class="fa fa-receipt w-5 text-center"></i>
                    <span class="ml-2 whitespace-nowrap" x-show="sidebarOpen" x-cloak>Orders</span>
                </a>
            @endcan

            @can('manage-payments')
                <a href="{{ route('stripe.payments') }}"
                   :title="sidebarOpen ? '' : 'Payments'"
                   class="flex items-center px-3 py-2 rounded-lg text-md font-medium no-underline
                          {{ request()->routeIs('stripe.payments') ? 'bg-blue-600 text-white shadow-sm' : 'text-gray-600 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-gray-700 hover:text-blue-600' }} transition-all duration-150">
                    <i class="fa fa-money-check-alt w-5 text-center"></i>
                    <span class="ml-2 whitespace-nowrap" x-show="sidebarOpen" x-cloak>Payments</span>
                </a>
            @endcan
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col min-h-screen"
         :class="sidebarOpen ? 'ml-64' : 'ml-20'">
        @isset($header)
            <header x-data="{ openUserMenu: false }"
                    class="sticky top-0 z-30 bg-white/90 dark:bg-gray-800/90 border-b border-gray-200 dark:border-gray-700 px-6 py-4 backdrop-blur">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <button
                            type="button"
                            @click="toggleSidebar()"
                            class="inline-flex items-center justify-center w-9 h-9 rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-600 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-800 shadow-sm transition-colors duration-150">
                            <i class="fa fa-bars text-sm"></i>
                        </button>
                        <div>
                            {{ $header }}
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <button @click="openUserMenu = !openUserMenu"
                                    class="w-10 h-10 rounded-full overflow-hidden border-2 border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 hover:border-blue-500 transition-all duration-300">
                                <img
                                    src="{{ Auth::user()->profile_image ? asset('storage/uploads/users/' . Auth::user()->profile_image) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) }}"
                                    alt="Profile Image"
                                    class="w-full h-full object-cover">
                            </button>

                            <div x-show="openUserMenu"
                                 x-cloak
                                 @click.away="openUserMenu = false"
                                 x-transition
                                 class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-lg py-2 z-50">
                                <a href="{{ route('profile.edit') }}"
                                   class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 no-underline">
                                    Profile
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                            class="w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
        @endisset

        <main class="flex-1 px-4 sm:px-6 lg:px-8 py-4 overflow-y-auto">
            {{ $slot }}
        </main>
    </div>

</div>
