<!-- Sidebar + Main Layout Wrapper -->
<div class="d-flex">

    <!-- Sidebar -->
    <div class="sidebar bg-white dark:bg-gray-800 border-end" style="width: 230px; min-height: 100vh;">

        <div class="p-3 border-bottom d-flex align-items-center">
            <a href="{{ route('dashboard') }}" class="d-flex align-items-center text-decoration-none">
                <x-application-logo class="h-8 w-auto text-gray-800 dark:text-gray-200" />
                <span class="ms-2 fw-bold text-dark dark:text-gray-200">SIOMS</span>
            </a>
        </div>

        <ul class="nav flex-column py-3">

            @if (Auth::user()->hasRole('customer'))
                <!-- Products -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('product.listing') ? 'active' : '' }}"
                       href="{{ route('product.listing') }}">
                        <i class="fa fa-box"></i> <span class="ms-2">Products</span>
                    </a>
                </li>

                <!-- Cart -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('cart.index') ? 'active' : '' }}"
                       href="{{ route('cart.index') }}">
                        <i class="fa fa-shopping-cart"></i>
                        <span class="ms-2">Cart</span>

                        @php
                            $cart = session('cart', []);
                            $cartCount = collect($cart)->sum('quantity');
                        @endphp

                        @if ($cartCount > 0)
                            <span class="badge bg-danger ms-2">{{ $cartCount }}</span>
                        @endif
                    </a>
                </li>

            @else
                <!-- Dashboard -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                       href="{{ route('dashboard') }}">
                        <i class="fa fa-home"></i> <span class="ms-2">Dashboard</span>
                    </a>
                </li>

                <!-- Products -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('product.index') ? 'active' : '' }}"
                       href="{{ route('product.index') }}">
                        <i class="fa fa-boxes"></i> <span class="ms-2">Products</span>
                    </a>
                </li>
            @endif

            @can('manage-staffs')
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('staff.index') ? 'active' : '' }}"
                       href="{{ route('staff.index') }}">
                        <i class="fa fa-users"></i> <span class="ms-2">Staffs</span>
                    </a>
                </li>
            @endcan


            @can('manage-permissions')
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('roles.index') ? 'active' : '' }}"
                       href="{{ route('roles.index') }}">
                        <i class="fa fa-key"></i> <span class="ms-2">Permissions</span>
                    </a>
                </li>
            @endcan

            {{-- @can('manage-inventory') --}}
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('inventory.index') ? 'active' : '' }}"
                       href="{{ route('inventory.index') }}">
                        <i class="fa fa-box"></i> <span class="ms-2">Inventory</span>
                    </a>
                </li>
            {{-- @endcan --}}

            <!-- Profile -->
            <li class="nav-item mt-3 border-top pt-3">
                <a class="nav-link {{ request()->routeIs('profile.edit') ? 'active' : '' }}"
                   href="{{ route('profile.edit') }}">
                    <i class="fa fa-user"></i> <span class="ms-2">Profile</span>
                </a>
            </li>

            <!-- Logout -->
            <li class="nav-item">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a class="nav-link text-danger" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        <i class="fa fa-right-from-bracket"></i> <span class="ms-2">Logout</span>
                    </a>
                </form>
            </li>

        </ul>
    </div>

    <!-- Main Content -->
    <div class="flex-grow-1" style="min-height: 100vh;">
        <!-- Keep your existing header + slot area -->
        @isset($header)
            <header class="bg-white dark:bg-gray-800 shadow p-4 mb-3">
                {{ $header }}
            </header>
        @endisset

        <main class="p-3">
            {{ $slot }}
        </main>
    </div>

</div>
