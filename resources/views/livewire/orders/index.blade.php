<div class="p-4" wire:poll.5s>

    {{-- Search & Status Filter --}}
    <div class="mb-4 flex justify-end space-x-2">
        <input type="text" wire:model="search" wire:keyup="set('search',$event.target.value)"
            placeholder="Search orders..."
            class="border rounded px-4 py-2 w-64 focus:outline-none focus:ring focus:border-blue-300">

        <select wire:model="status" wire:change="set('status',$event.target.value)"
            class="border rounded px-4 w-56 py-2 focus:outline-none focus:ring focus:border-blue-300">
            <option value="">All Statuses</option>
            @foreach ($statuses as $key => $label)
                <option value="{{ $key }}">{{ $label }}</option>
            @endforeach
        </select>
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
                    <td class="border px-4 py-2">
                        @php
                            $badgeColor = match ($order->status) {
                                'pending' => 'bg-yellow-300 text-yellow-800',
                                'confirmed' => 'bg-blue-300 text-blue-800',
                                'delivered' => 'bg-indigo-300 text-indigo-800',
                                'completed' => 'bg-green-300 text-green-800',
                                'cancelled' => 'bg-red-300 text-red-800',
                                default => 'bg-gray-300 text-gray-800',
                            };
                        @endphp
                        <span onclick="openStatusModal({{ $order->id }}, '{{ $order->status }}')"
                            class="cursor-pointer px-3 py-1 rounded-full {{ $badgeColor }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
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

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const statuses = @json($statuses);

        // Make this function global
        window.openStatusModal = function(orderId, currentStatus) {
            const component = Livewire.find(@this.id); // get current Livewire component

            let statusOptions = Object.entries(statuses).map(([key, label]) => {
                let selected = key === currentStatus ? 'selected' : '';
                return `<option value="${key}" ${selected}>${label}</option>`;
            }).join('');

            Swal.fire({
                title: 'Change Order Status',
                html: `<select id="swal-status" class="border rounded px-4 py-2 w-full">${statusOptions}</select>`,
                showCancelButton: true,
                confirmButtonText: 'Update',
                preConfirm: () => {
                    const newStatus = Swal.getPopup().querySelector('#swal-status').value;
                    if (!newStatus) Swal.showValidationMessage('Please select a status');
                    return newStatus;
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    component.call('changeStatus', orderId, result.value)
                        .then(() => {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: `Order status updated to ${result.value}`,
                                timer: 2000,
                                showConfirmButton: false
                            });
                        });
                }
            });
        };
    </script>
@endpush
