<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-full sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{-- Summary Cards --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        {{-- Total Products Card --}}
                        <a href="{{ route('product.index') }}" class="group">
                            <div class="bg-gradient-to-br from-blue-500 to-blue-600 text-white shadow-lg rounded-xl p-6 transform transition-all duration-300 hover:scale-105 hover:shadow-xl cursor-pointer">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                        </svg>
                                    </div>
                                    <svg class="w-5 h-5 opacity-50 group-hover:opacity-100 group-hover:translate-x-1 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </div>
                                <h3 class="text-blue-100 text-sm font-semibold mb-1">Total Products</h3>
                                <p class="text-3xl font-bold">{{ $totalProducts }}</p>
                            </div>
                        </a>

                        {{-- Total Stock Value Card --}}
                        <div class="bg-gradient-to-br from-green-500 to-green-600 text-white shadow-lg rounded-xl p-6">
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

                        {{-- Low Stock Items Card --}}
                        <a href="{{ route('product.index', ['lowStock' => 1]) }}" class="group">
                            <div class="bg-gradient-to-br from-red-500 to-red-600 text-white shadow-lg rounded-xl p-6 transform transition-all duration-300 hover:scale-105 hover:shadow-xl cursor-pointer">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                        </svg>
                                    </div>
                                    <svg class="w-5 h-5 opacity-50 group-hover:opacity-100 group-hover:translate-x-1 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </div>
                                <h3 class="text-red-100 text-sm font-semibold mb-1">Low Stock Items</h3>
                                <p class="text-3xl font-bold">{{ $lowStockItems }}</p>
                            </div>
                        </a>
                    </div>

                    {{-- Charts --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Monthly Sales --}}
                        <div class="bg-white shadow-lg rounded-xl p-6 border border-gray-100">
                            <h3 class="text-gray-700 font-bold text-lg mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                </svg>
                                Monthly Sales
                            </h3>
                            <canvas id="monthlySalesChart"></canvas>
                        </div>

                        {{-- Inventory Movement --}}
                        <div class="bg-white shadow-lg rounded-xl p-6 border border-gray-100">
                            <h3 class="text-gray-700 font-bold text-lg mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
            </div>
        </div>
    </div>
</x-app-layout>
