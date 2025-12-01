<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{-- Summary Cards --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        <div class="bg-white shadow p-4 rounded">
                            <h3 class="text-gray-500">Total Products</h3>
                            <p class="text-2xl font-bold">{{ $totalProducts }}</p>
                        </div>
                        <div class="bg-white shadow p-4 rounded">
                            <h3 class="text-gray-500">Total Stock Value</h3>
                            <p class="text-2xl font-bold">${{ number_format($totalStockValue, 2) }}</p>
                        </div>
                        <div class="bg-white shadow p-4 rounded">
                            <h3 class="text-gray-500">Low Stock Items</h3>
                            <p class="text-2xl font-bold">{{ $lowStockItems }}</p>
                        </div>
                    </div>

                    {{-- Charts --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        {{-- Monthly Sales --}}
                        <div class="bg-white shadow p-4 rounded">
                            <h3 class="text-gray-500 mb-2">Monthly Sales</h3>
                            <canvas id="monthlySalesChart"></canvas>
                        </div>

                        {{-- Inventory Movement --}}
                        <div class="bg-white shadow p-4 rounded">
                            <h3 class="text-gray-500 mb-2">Inventory Movement</h3>
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
