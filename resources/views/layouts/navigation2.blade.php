<!-- Sidebar + Main Layout Wrapper -->
<div class="min-h-screen bg-gray-100 dark:bg-gray-900 flex">

    <!-- Sidebar (fixed) -->
    <aside class="fixed inset-y-0 left-0 bg-white dark:bg-gray-800 w-64 border-r border-gray-200 dark:border-gray-700 flex flex-col z-40">
        <!-- Brand -->
        <div class="px-4 py-4 border-b border-gray-200 dark:border-gray-700 flex items-center">
            <a href="{{ route('dashboard') }}" class="flex items-center space-x-2 no-underline">
                <x-application-logo class="h-8 w-auto text-blue-600 dark:text-blue-400" />
                <span class="font-extrabold text-lg bg-gradient-to-r from-blue-600 to-blue-400 bg-clip-text text-transparent">
                    SIOMS
                </span>
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

            <!-- Products -->
            <a href="{{ route('product.index') }}"
               class="flex items-center px-3 py-2 rounded-lg text-sm font-medium no-underline
                      {{ request()->routeIs('product.index') ? 'bg-blue-600 text-white shadow-sm' : 'text-gray-600 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-gray-700 hover:text-blue-600' }} transition-all duration-150">
                <i class="fa fa-boxes w-5"></i>
                <span class="ml-2">Products</span>
            </a>

            @can('manage-staffs')
                <a href="{{ route('staff.index') }}"
                   class="flex items-center px-3 py-2 rounded-lg text-sm font-medium no-underline
                          {{ request()->routeIs('staff.index') ? 'bg-blue-600 text-white shadow-sm' : 'text-gray-600 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-gray-700 hover:text-blue-600' }} transition-all duration-150">
                    <i class="fa fa-users w-5"></i>
                    <span class="ml-2">Staffs</span>
                </a>

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

            <!-- Spacer -->
            <div class="flex-1"></div>

            <!-- Profile / Logout -->
            <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                <a href="{{ route('profile.edit') }}"
                   class="flex items-center px-3 py-2 rounded-lg text-sm font-medium no-underline
                          {{ request()->routeIs('profile.edit') ? 'bg-blue-600 text-white shadow-sm' : 'text-gray-600 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-gray-700 hover:text-blue-600' }} transition-all duration-150">
                    <i class="fa fa-user w-5"></i>
                    <span class="ml-2">Profile</span>
                </a>

                <form method="POST" action="{{ route('logout') }}" class="mt-2">
                    @csrf
                    <button type="submit"
                            class="flex items-center w-full px-3 py-2 rounded-lg text-sm font-medium text-red-600 dark:text-red-400 no-underline hover:bg-red-50 dark:hover:bg-red-700 hover:text-red-700 dark:hover:text-red-100 transition-all duration-150">
                        <i class="fa fa-right-from-bracket w-5"></i>
                        <span class="ml-2">Logout</span>
                    </button>
                </form>
            </div>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col ml-64 min-h-screen overflow-hidden">
        @isset($header)
            <header class="sticky top-0 z-30 bg-white/90 dark:bg-gray-800/90 border-b border-gray-200 dark:border-gray-700 px-6 py-4 backdrop-blur">
                {{ $header }}
            </header>
        @endisset

        <main class="flex-1 px-4 sm:px-6 lg:px-8 py-4 overflow-y-auto">
            {{ $slot }}
        </main>
    </div>

</div>
