<!-- Sidebar + Main Layout Wrapper -->
<div class="min-h-screen bg-gray-100 dark:bg-gray-900 flex">

    <!-- Sidebar (fixed) -->
    <aside class="fixed inset-y-0 left-0 bg-white dark:bg-gray-800 w-64 border-r border-gray-200 dark:border-gray-700 flex flex-col z-40">
        <!-- Brand -->
        <div class="py-6 px-6 border-b border-gray-200 dark:border-gray-700 flex items-center">
            <a href="{{ route('dashboard') }}" class="flex items-center space-x-2 no-underline">
                <img src="{{ asset('images/sioms-logo-horizontal.svg') }}"
                     alt="SIOMS"
                     class="h-11 w-auto">
            </a>
        </div>

        <!-- Navigation -->
        <nav class="mt-4 flex-1 flex flex-col space-y-1 px-2">
            <!-- Dashboard -->
            <a href="{{ route('dashboard') }}"
               class="flex items-center px-3 py-2 rounded-lg text-sm font-medium no-underline
                      {{ request()->routeIs('dashboard') ? 'bg-blue-600 text-white shadow-sm' : 'text-gray-600 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-gray-700 hover:text-blue-600' }} transition-all duration-150">
                <i class="fa fa-home w-5"></i>
                <span class="ml-2">Dashboard</span>
            </a>

            @can('view-products')
            <!-- Products -->
            <a href="{{ route('product.index') }}"
               class="flex items-center px-3 py-2 rounded-lg text-sm font-medium no-underline
                      {{ request()->routeIs('product.index') ? 'bg-blue-600 text-white shadow-sm' : 'text-gray-600 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-gray-700 hover:text-blue-600' }} transition-all duration-150">
                <i class="fa fa-boxes w-5"></i>
                <span class="ml-2">Products</span>
            </a>
            <a href="{{ route('category.index') }}"
               class="flex items-center px-3 py-2 rounded-lg text-sm font-medium no-underline
                      {{ request()->routeIs('category.index') ? 'bg-blue-600 text-white shadow-sm' : 'text-gray-600 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-gray-700 hover:text-blue-600' }} transition-all duration-150">
                <i class="fa fa-boxes w-5"></i>
                <span class="ml-2">Categories</span>
            </a>
            @endcan

            @can('manage-staffs')
                <a href="{{ route('staff.index') }}"
                   class="flex items-center px-3 py-2 rounded-lg text-sm font-medium no-underline
                          {{ request()->routeIs('staff.index') ? 'bg-blue-600 text-white shadow-sm' : 'text-gray-600 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-gray-700 hover:text-blue-600' }} transition-all duration-150">
                    <i class="fa fa-users w-5"></i>
                    <span class="ml-2">Staffs</span>
                </a>

                @endcan
                @can('manage-customers')
                <a href="{{ route('customers.index') }}"
                   class="flex items-center px-3 py-2 rounded-lg text-sm font-medium no-underline
                          {{ request()->routeIs('customers.index') ? 'bg-blue-600 text-white shadow-sm' : 'text-gray-600 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-gray-700 hover:text-blue-600' }} transition-all duration-150">
                    <i class="fa fa-user w-5"></i>
                    <span class="ml-2">Customers</span>
                </a>

                @endcan
            @can('manage-permissions')
                <a href="{{ route('roles.index') }}"
                   class="flex items-center px-3 py-2 rounded-lg text-sm font-medium no-underline
                          {{ request()->routeIs('roles.index') ? 'bg-blue-600 text-white shadow-sm' : 'text-gray-600 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-gray-700 hover:text-blue-600' }} transition-all duration-150">
                    <i class="fa fa-key w-5"></i>
                    <span class="ml-2">Roles & Permissions</span>
                </a>
            @endcan

            @can('manage-inventory')
                <a href="{{ route('inventory.index') }}"
                   class="flex items-center px-3 py-2 rounded-lg text-sm font-medium no-underline
                          {{ request()->routeIs('inventory.index') ? 'bg-blue-600 text-white shadow-sm' : 'text-gray-600 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-gray-700 hover:text-blue-600' }} transition-all duration-150">
                    <i class="fa fa-box w-5"></i>
                    <span class="ml-2">Inventory</span>
                </a>
            @endcan

            @can('manage-orders')
                <a href="{{ route('orders.index') }}"
                   class="flex items-center px-3 py-2 rounded-lg text-sm font-medium no-underline
                          {{ request()->routeIs('orders.index') ? 'bg-blue-600 text-white shadow-sm' : 'text-gray-600 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-gray-700 hover:text-blue-600' }} transition-all duration-150">
                    <i class="fa fa-receipt w-5"></i>
                    <span class="ml-2">Orders</span>
                </a>
            @endcan

        </nav>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col ml-64 min-h-screen">
        @isset($header)
            <header x-data="{ openUserMenu: false }"
                    class="sticky top-0 z-30 bg-white/90 dark:bg-gray-800/90 border-b border-gray-200 dark:border-gray-700 px-6 py-4 backdrop-blur">
                <div class="flex items-center justify-between">
                    <div>
                        {{ $header }}
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
