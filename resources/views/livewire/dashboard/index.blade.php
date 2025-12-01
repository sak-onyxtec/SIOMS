<div class="p-4">
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
        <div class="bg-white shadow p-4 rounded">
            <h3 class="text-gray-500 mb-2">Monthly Sales</h3>
            {!! $monthlySalesChart->container() !!}
        </div>
        <div class="bg-white shadow p-4 rounded">
            <h3 class="text-gray-500 mb-2">Inventory Movement</h3>
            {!! $inventoryMovementChart->container() !!}
        </div>
    </div>

    @push('scripts')
        {{-- Load Chart.js first --}}
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <script>
            document.addEventListener('livewire:load', () => {
                // Render charts after Livewire renders DOM
                {!! $monthlySalesChart->script() !!}
                {!! $inventoryMovementChart->script() !!}
            });

            // Optional: re-render charts after Livewire updates (if using polling or reactive filters)
            Livewire.hook('message.processed', (message, component) => {
                {!! $monthlySalesChart->script() !!}
                {!! $inventoryMovementChart->script() !!}
            });
        </script>
    @endpush
</div>
