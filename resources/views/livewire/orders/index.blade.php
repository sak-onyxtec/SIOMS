<div class="p-6">
    {{-- Loading Overlay --}}
    {{-- <div wire:loading wire:target="changeStatus" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
        <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4 shadow-xl">
            <div class="flex flex-col items-center">
                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mb-4"></div>
                <p class="text-lg font-semibold text-gray-800">Updating order status...</p>
                <p class="text-sm text-gray-600 mt-2">Please wait while we process your request</p>
            </div>
        </div>
    </div> --}}

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-gray-800">
            Orders
        </h2>
    </div>

    {{-- Filters (status only, text search handled by DataTable) --}}
    <div class="mb-4 flex flex-col sm:flex-row gap-4 justify-start items-end">
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Filter by Status</label>
            <select
                id="orders-status-filter"
                wire:model="status"
                class="w-56 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                <option value="">All Statuses</option>
                @foreach ($statuses as $key => $label)
                    <option value="{{ $label }}">{{ $label }}</option>
                @endforeach
            </select>
        </div>

        <button
            id="orders-clear-filters"
            type="button"
            class="relative inline-flex items-center px-3 py-2 text-md font-semibold text-red-600 hover:text-red-800 bg-red-50 hover:bg-red-100 rounded-lg border border-red-100 shadow-sm hidden">
            <span class="absolute -top-1 -right-1 inline-flex h-2.5 w-2.5 rounded-full bg-red-500"></span>
            Clear filters
        </button>
    </div>

    {{-- Orders Table --}}
    <div class="bg-white">
        <div class="">
            <table class="w-full js-datatable" id="orders-table">
                <thead>
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
                                <span
                                      class="   px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $badgeClasses }} relative"
                                      wire:loading.attr="disabled"
                                      wire:target="changeStatus">
                                    <span wire:loading.remove wire:target="changeStatus">{{ ucfirst($order->status) }}</span>
                                    <span wire:loading wire:target="changeStatus" class="flex items-center">
                                        <svg class="animate-spin -ml-1 mr-2 h-3 w-3 text-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        Updating...
                                    </span>
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
                    // Show loading state
                    Swal.fire({
                        title: 'Updating Status...',
                        html: 'Please wait while we update the order status',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    
                    component.call('changeStatus', orderId, result.value)
                        .then(() => {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: `Order status updated to ${result.value}`,
                                timer: 2000,
                                showConfirmButton: false
                            });
                        })
                        .catch((error) => {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Failed to update order status. Please try again.',
                                confirmButtonText: 'OK'
                            });
                        });
                }
            });
        };

        document.addEventListener('DOMContentLoaded', function () {
            const statusFilter = document.getElementById('orders-status-filter');
            const clearBtn = document.getElementById('orders-clear-filters');

            if (!statusFilter || !clearBtn) {
                return;
            }

            function updateClearVisibility() {
                if (statusFilter.value) {
                    clearBtn.classList.remove('hidden');
                } else {
                    clearBtn.classList.add('hidden');
                }
            }

            statusFilter.addEventListener('change', updateClearVisibility);

            clearBtn.addEventListener('click', function () {
                statusFilter.value = '';
                statusFilter.dispatchEvent(new Event('change'));
                updateClearVisibility();
            });

            updateClearVisibility();
        });
    </script>
@endpush
