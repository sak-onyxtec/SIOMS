<div class="p-4">

    {{-- Search --}}
    <div class="mb-4 flex justify-end">
        <input type="text" wire:model="search" wire:keyup="set('search',$event.target.value)"
            placeholder="Search orders..."
            class="border rounded px-4 py-2 w-64 focus:outline-none focus:ring focus:border-blue-300">
    </div>

    {{-- Orders Table --}}
    <table class="w-full table-auto border-collapse">
        <thead>
            <tr class="bg-gray-100">
                <th class="border px-4 py-2 text-left">Order ID</th>
                <th class="border px-4 py-2 text-left">Total</th>
                <th class="border px-4 py-2 text-left">Status</th>
                <th class="border px-4 py-2 text-left">Date</th>
                <th class="border px-4 py-2 text-left">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
                <tr>
                    <td class="border px-4 py-2">{{ $order->uid }}</td>
                    <td class="border px-4 py-2">${{ number_format($order->total, 2) }}</td>
                    <td class="border px-4 py-2">{{ ucfirst($order->status) }}</td>
                    <td class="border px-4 py-2">{{ $order->created_at->format('d M Y') }}</td>
                    <td class="border px-4 py-2">
                        <a href="{{ route('orders.detail', $order->id) }}"
                            class="px-3 no-underline py-1 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">
                            <i class="fa fa-eye"></i>
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="border px-4 py-2 text-center text-gray-500">No orders found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $orders->links() }}
    </div>
</div>
