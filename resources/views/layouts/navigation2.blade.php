<!-- Sidebar + Main Layout Wrapper -->
<div class="flex min-h-screen">

    <!-- Sidebar -->
    <aside class="bg-white dark:bg-gray-800 w-56 border-r">
        <div class="p-4 border-b flex items-center">
            <a href="{{ route('dashboard') }}" class="flex items-center space-x-2 no-underline">
                <x-application-logo class="h-8 w-auto text-gray-800 dark:text-gray-200" />
                <span class="font-bold text-gray-800 dark:text-gray-200">SIOMS</span>
            </a>
        </div>

        <nav class="mt-4 flex flex-col">
            <!-- Dashboard -->
            <a href="{{ route('dashboard') }}"
                class="flex items-center px-4 py-2 text-gray-600 dark:text-gray-300 no-underline hover:bg-blue-500 hover:text-white transition
               {{ request()->routeIs('dashboard') ? 'bg-blue-500 text-white' : '' }}">
                <i class="fa fa-home w-5"></i>
                <span class="ml-2">Dashboard</span>
            </a>

            <!-- Products -->
            <a href="{{ route('product.index') }}"
                class="flex items-center px-4 py-2 text-gray-600 dark:text-gray-300 no-underline hover:bg-blue-500 hover:text-white transition
               {{ request()->routeIs('product.index') ? 'bg-blue-500 text-white' : '' }}">
                <i class="fa fa-boxes w-5"></i>
                <span class="ml-2">Products</span>
            </a>

            @can('manage-staffs')
                <a href="{{ route('staff.index') }}"
                    class="flex items-center px-4 py-2 text-gray-600 dark:text-gray-300 no-underline hover:bg-blue-500 hover:text-white transition
                   {{ request()->routeIs('staff.index') ? 'bg-blue-500 text-white' : '' }}">
                    <i class="fa fa-users w-5"></i>
                    <span class="ml-2">Staffs</span>
                </a>
            @endcan

            @can('manage-permissions')
                <a href="{{ route('roles.index') }}"
                    class="flex items-center px-4 py-2 text-gray-600 dark:text-gray-300 no-underline hover:bg-blue-500 hover:text-white transition
                   {{ request()->routeIs('roles.index') ? 'bg-blue-500 text-white' : '' }}">
                    <i class="fa fa-key w-5"></i>
                    <span class="ml-2">Permissions</span>
                </a>
            @endcan

            <a href="{{ route('inventory.index') }}"
                class="flex items-center px-4 py-2 text-gray-600 dark:text-gray-300 no-underline hover:bg-blue-500 hover:text-white transition
               {{ request()->routeIs('inventory.index') ? 'bg-blue-500 text-white' : '' }}">
                <i class="fa fa-box w-5"></i>
                <span class="ml-2">Inventory</span>
            </a>

            <!-- Profile -->
            <div class="mt-6 border-t pt-3">
                <a href="{{ route('profile.edit') }}"
                    class="flex items-center px-4 py-2 text-gray-600 dark:text-gray-300 no-underline hover:bg-blue-500 hover:text-white transition
                   {{ request()->routeIs('profile.edit') ? 'bg-blue-500 text-white' : '' }}">
                    <i class="fa fa-user w-5"></i>
                    <span class="ml-2">Profile</span>
                </a>

                <!-- Logout -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="flex items-center w-full px-4 py-2 mt-2 text-red-600 dark:text-red-400 no-underline hover:bg-red-100 dark:hover:bg-red-700 hover:text-red-700 dark:hover:text-red-100 transition">
                        <i class="fa fa-right-from-bracket w-5"></i>
                        <span class="ml-2">Logout</span>
                    </button>
                </form>
            </div>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 bg-gray-100 dark:bg-gray-900">
        @isset($header)
            <header class="bg-white dark:bg-gray-800 p-4 mb-3">
                {{ $header }}
            </header>
        @endisset

        <main>
            {{ $slot }}
        </main>
    </div>

</div>
