<div class="p-6" wire:poll>

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-gray-800">
            Orders
        </h2>
    </div>

    {{-- Filters --}}
    <div class="mb-4 flex flex-col sm:flex-row gap-4 justify-end">
        <div>
            <input
                type="text"
                wire:model.live.debounce.300ms="search"
                placeholder="Search by Order ID or Status..."
                class="w-64 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200 shadow-sm hover:shadow-md">
        </div>

        <div>
            <select
                wire:model="status"
                class="w-56 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                <option value="">All Statuses</option>
                @foreach ($statuses as $key => $label)
                    <option value="{{ $key }}">{{ $label }}</option>
                @endforeach
            </select>
        </div>
    </div>

    {{-- Orders Table --}}
    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gradient-to-r from-blue-50 to-blue-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Order ID
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Total
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Date
                        </th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider w-32">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($orders as $order)
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-6 py-3 text-sm font-semibold text-gray-900">
                                {{ $order->uid }}
                            </td>
                            <td class="px-6 py-3 text-sm font-semibold text-gray-800">
                                ${{ number_format($order->total, 2) }}
                            </td>
                            <td class="px-6 py-3 text-sm">
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
                                <span onclick="openStatusModal({{ $order->id }}, '{{ $order->status }}')"
                                      class="cursor-pointer px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $badgeClasses }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-3 text-sm text-gray-600">
                                {{ $order->created_at->format('d M Y') }}
                            </td>
                            <td class="px-6 py-3 text-sm text-center">
                                <a href="{{ route('orders.detail', $order->id) }}"
                                   class="inline-flex items-center no-underline px-3 py-1 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-xs font-semibold transition-colors duration-200"
                                   title="View Details">
                                    <i class="fa fa-eye mr-1"></i> View
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                <div class="flex flex-col items-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <p class="text-lg font-medium">No orders found</p>
                                    <p class="text-sm mt-1">Try adjusting your search or filters.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

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
