<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="px-4 sm:px-6 lg:px-8 py-4 text-gray-900 dark:text-gray-100">

        {{-- Welcome Banner --}}
        <div class="mb-8 bg-gradient-to-r from-blue-500 via-indigo-500 to-blue-400 rounded-2xl shadow-lg px-6 py-5 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <p class="text-xs font-semibold tracking-wide text-blue-100 uppercase mb-1">Welcome back</p>
                <h1 class="text-2xl md:text-3xl font-bold text-white">
                    {{ auth()->user()->name ?? 'Admin' }},
                    <span class="font-normal text-blue-100">here is an overview of your inventory & orders.</span>
                </h1>
            </div>
            <div class="flex items-center gap-4">
                <div class="hidden sm:block">
                    <p class="text-xs text-blue-100 uppercase tracking-wide mb-1">Total Orders</p>
                    <p class="text-2xl font-bold text-white text-right">{{ $totalOrders }}</p>
                </div>
                <div class="hidden sm:block">
                    <p class="text-xs text-blue-100 uppercase tracking-wide mb-1">Pending Orders</p>
                    <p class="text-2xl font-bold text-white text-right">{{ $totalPendingOrders }}</p>
                </div>
            </div>
        </div>

        {{-- Summary Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
                        <a href="{{ route('product.index') }}" class="group no-underline">
                            <div class="no-underline bg-gradient-to-br from-blue-400 to-blue-500 text-white shadow-lg rounded-xl p-6 transform transition-all duration-400 hover:scale-105 hover:shadow-xl cursor-pointer">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                        </svg>
                                    </div>
                                    <svg class="w-5 h-5 opacity-50 group-hover:opacity-100 group-hover:translate-x-1 transition-all duration-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </div>
                                <h3 class="text-blue-100 text-sm font-semibold mb-1">Total Products</h3>
                                <p class="text-3xl font-bold">{{ $totalProducts }}</p>
                            </div>
                        </a>

                        <div class="bg-gradient-to-br from-green-400 to-green-500 text-white shadow-lg rounded-xl p-6">
                            <div class="flex items-center justify-between mb-4">
                                <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <h3 class="text-green-100 text-sm font-semibold mb-1">Total Stock Value</h3>
                            <p class="text-3xl font-bold">${{ number_format($totalStockValue, 2) }}</p>
                        </div>

                        <a href="{{ route('product.index', ['lowStock' => 1]) }}" class="group no-underline">
                            <div class="no-underline bg-gradient-to-br from-red-400 to-red-500 text-white shadow-lg rounded-xl p-6 transform transition-all duration-400 hover:scale-105 hover:shadow-xl cursor-pointer">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                        </svg>
                                    </div>
                                    <svg class="w-5 h-5 opacity-50 group-hover:opacity-100 group-hover:translate-x-1 transition-all duration-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </div>
                                <h3 class="text-red-100 text-sm font-semibold mb-1">Low Stock Items</h3>
                                <p class="text-3xl font-bold">{{ $lowStockItems }}</p>
                            </div>
                        </a>
                        {{-- Total Orders Card --}}
                        <a href="{{ route('orders.index') }}" class="group no-underline">
                            <div class="no-underline bg-gradient-to-br from-purple-400 to-purple-500 text-white shadow-lg rounded-xl p-6 transform transition-all duration-400 hover:scale-105 hover:shadow-xl cursor-pointer">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M5 11h14m-9 4h4M5 3h14a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2z" />
                                        </svg>
                                    </div>
                                    <svg class="w-5 h-5 opacity-50 group-hover:opacity-100 group-hover:translate-x-1 transition-all duration-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </div>
                                <h3 class="text-purple-100 text-sm font-semibold mb-1">Total Orders</h3>
                                <p class="text-3xl font-bold">{{ $totalOrders }}</p>
                            </div>
                        </a>

                        {{-- Pending Orders Card --}}
                        <a href="{{ route('orders.index', ['status' => 'pending']) }}" class="group no-underline">
                            <div class="no-underline bg-gradient-to-br from-yellow-400 to-yellow-500 text-white shadow-lg rounded-xl p-6 transform transition-all duration-400 hover:scale-105 hover:shadow-xl cursor-pointer">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m5-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <svg class="w-5 h-5 opacity-50 group-hover:opacity-100 group-hover:translate-x-1 transition-all duration-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </div>
                                <h3 class="text-yellow-100 text-sm font-semibold mb-1">Pending Orders</h3>
                                <p class="text-3xl font-bold">{{ $totalPendingOrders }}</p>
                            </div>
                        </a>
                    </div>

        {{-- Latest Products & Orders --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            {{-- Latest Products --}}
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Latest Products</h3>
                    <a href="{{ route('product.index') }}" class="text-sm text-blue-500 no-underline hover:text-blue-700">View all</a>
                </div>
                <div class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($latestProducts as $product)
                        <div class="px-6 py-4 flex items-center gap-4">
                            @if($product->product_image)
                                <img src="{{ $product->product_image }}" class="w-12 h-12 rounded-md object-cover shadow-sm" alt="{{ $product->name }}">
                            @else
                                <div class="w-12 h-12 rounded-md bg-gray-100 flex items-center justify-center">
                                    <i class="fas fa-image text-gray-500 text-sm"></i>
                                </div>
                            @endif
                            <div class="flex-1">
                                <p class="text-sm font-semibold text-gray-800 dark:text-gray-100">{{ $product->name }}</p>
                                <p class="text-xs text-gray-400">
                                    SKU: {{ $product->sku }} ·
                                    <span class="font-medium">${{ number_format($product->price, 2) }}</span>
                                </p>
                            </div>
                            <div>
                                <span class="px-2 py-1 text-xs font-semibold rounded-full
                                    {{ $product->quantity <= 5 ? 'bg-red-100 text-red-800' : ($product->quantity <= 10 ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">
                                    {{ $product->quantity }} in stock
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="px-6 py-6 text-sm text-gray-400 text-center">
                            No recent products.
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Latest Orders --}}
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Latest Orders</h3>
                    <a href="{{ route('orders.index') }}" class="text-sm text-blue-500 no-underline hover:text-blue-700">View all</a>
                </div>
                <div class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($latestOrders as $order)
                        <div class="px-6 py-4 flex items-center justify-between gap-4">
                            <div>
                                <p class="text-sm font-semibold text-gray-800 dark:text-gray-100">#{{ $order->uid }}</p>
                                <p class="text-xs text-gray-400">
                                    {{ $order->created_at->format('d M Y, h:i A') }}
                                </p>
                            </div>
                            <div>
                                @php
                                    $badgeClasses = match ($order->status) {
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        'confirmed' => 'bg-blue-100 text-blue-800',
                                        'delivered' => 'bg-indigo-100 text-indigo-800',
                                        'completed' => 'bg-green-100 text-green-800',
                                        'cancelled' => 'bg-red-100 text-red-800',
                                        default => 'bg-gray-100 text-gray-800',
                                    };
                                @endphp
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $badgeClasses }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-semibold text-gray-800 dark:text-gray-100">
                                    ${{ number_format($order->total, 2) }}
                                </p>
                            </div>
                        </div>
                    @empty
                        <div class="px-6 py-6 text-sm text-gray-400 text-center">
                            No recent orders.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Charts --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Monthly Sales --}}
            <div class="bg-white shadow-lg rounded-xl p-6 border border-gray-100">
                            <h3 class="text-gray-700 font-bold text-lg mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                </svg>
                                Monthly Sales
                            </h3>
                            <canvas id="monthlySalesChart"></canvas>
                        </div>

                        {{-- Inventory Movement --}}
            <div class="bg-white shadow-lg rounded-xl p-6 border border-gray-100">
                <h3 class="text-gray-700 font-bold text-lg mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    Inventory Movement
                </h3>
                <canvas id="inventoryMovementChart"></canvas>
            </div>
        </div>

        @push('scripts')
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                const monthlySalesCtx = document.getElementById('monthlySalesChart').getContext('2d');
                new Chart(monthlySalesCtx, {
                    type: 'line',
                    data: {
                        labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                        datasets: [{
                            label: 'Sales',
                            data: @json($monthlySales),
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 2,
                            fill: true,
                        }]
                    },
                    options: {
                        responsive: true
                    }
                });

                const inventoryMovementCtx = document.getElementById('inventoryMovementChart').getContext('2d');
                new Chart(inventoryMovementCtx, {
                    type: 'bar',
                    data: {
                        labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                        datasets: [{
                                label: 'Stock In',
                                data: @json(array_column($inventoryMovement, 'in')),
                                backgroundColor: 'rgba(75, 192, 192, 0.6)'
                            },
                            {
                                label: 'Stock Out',
                                data: @json(array_column($inventoryMovement, 'out')),
                                backgroundColor: 'rgba(255, 99, 132, 0.6)'
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            </script>
        @endpush
    </div>
</x-app-layout>
