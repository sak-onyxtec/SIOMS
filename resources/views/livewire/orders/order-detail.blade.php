<div class="max-w-6xl mx-auto p-6" wire:poll>

    {{-- Back Button --}}
    <div class="mb-6">
        <a href="{{ Auth::user()->hasRole('customer') ? route('orders.my') : route('orders.index') }}"
            class="inline-flex items-center no-underline px-4 py-2 bg-gray-100 text-gray-800 rounded-lg hover:bg-gray-200 transition-colors duration-200">
            <i class="fa fa-arrow-left mr-2"></i> Back to Orders
        </a>
    </div>

    @if ($order)
        {{-- Order Summary --}}
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 mb-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 mb-2">
                        Order {{ $order->uid }}
                    </h2>
                    <p class="text-sm text-gray-600">
                        Placed on {{ $order->created_at->format('d M Y, h:i A') }}
                    </p>
                    @php
                    $isRefunded = !is_null($order->refunded_at);
                @endphp
                {{-- Receipt / Refund Receipt Actions --}}
                @if(!is_null($order->paid_at))
                    <div class="mt-4 flex flex-wrap gap-3">
                        <a href="{{ route('orders.web.receipt', $order->id) }}"
                        class="inline-flex no-underline items-center px-4 py-2 bg-emerald-600 text-white text-sm font-semibold rounded-lg hover:bg-emerald-700 transition-colors duration-200"
                        download>
                            <i class="fa fa-download mr-2"></i>
                            {{ $isRefunded ? 'Download Refund Receipt' : 'Download Receipt' }}
                        </a>
                    </div>
                @endif
                </div>
                <div class="flex flex-col items-start md:items-end gap-2">
                    <div class="flex flex-row items-center gap-2 flex-wrap justify-end">
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
                            <span onclick="openStatusModal({{ $order->id }}, '{{ $order->status }}')"
                                class="cursor-pointer px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $badgeClasses }} relative"
                                wire:loading.attr="disabled" wire:target="changeStatus">
                                <span wire:loading.remove
                                    wire:target="changeStatus">{{ ucfirst($order->status) }}</span>
                                <span wire:loading wire:target="changeStatus" class="flex items-center">
                                    <svg class="animate-spin -ml-1 mr-2 h-3 w-3 text-current"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                            stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>
                                    Updating...
                                </span>
                            </span>
                        </div>
                        <div>
                            @php
                                $isPaid = !is_null($order->paid_at);
                                $paymentBadgeClasses = $isPaid
                                    ? 'bg-green-100 text-green-800'
                                    : 'bg-red-100 text-red-800';
                            @endphp
                            <span
                                class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $paymentBadgeClasses }}">
                                <i class="fa {{ $isPaid ? 'fa-check-circle' : 'fa-times-circle' }} mr-1 mt-1"></i>
                                {{ $isPaid ? 'Paid' : 'Not Paid' }}
                            </span>
                        </div>
                        @php
                            $isRefunded = !is_null($order->refunded_at);
                        @endphp
                        @if($isRefunded)
                            <div>
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-orange-100 text-orange-800">
                                    <i class="fa fa-undo mr-1 mt-1"></i>
                                    Refunded
                                </span>
                            </div>
                        @endif
                    </div>
                    @php
                        $isPaid = !is_null($order->paid_at);
                        $isRefunded = !is_null($order->refunded_at);
                    @endphp
                    @if ($isPaid && $order->paid_at)
                        <p class="text-xs text-gray-500 text-right">
                            Paid on {{ $order->paid_at->format('d M Y, h:i A') }}
                        </p>
                    @endif
                    @if ($isRefunded && $order->refunded_at)
                        <p class="text-xs text-orange-600 text-right font-medium">
                            Refunded on {{ $order->refunded_at->format('d M Y, h:i A') }}
                            @if($order->stripe_refund_id)
                                <span class="text-gray-500">(ID: {{ substr($order->stripe_refund_id, 0, 20) }}...)</span>
                            @endif
                        </p>
                    @endif
                    <div class="text-right">
                        <p class="text-xs text-gray-500 uppercase tracking-wide">Total</p>
                        <p class="text-2xl font-bold text-blue-600">
                            ${{ number_format($order->total, 2) }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Items Table --}}
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 mb-6 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-800">Items</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th
                                class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Product</th>
                            <th
                                class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Quantity</th>
                            <th
                                class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Unit Price</th>
                            <th
                                class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Total</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($order->items as $item)
                            <tr>
                                <td class="px-6 py-3 text-sm text-gray-800">
                                    <div class="flex items-center gap-3">
                                        @if ($item->product->product_image)
                                            <img src="{{ $item->product->product_image }}"
                                                alt="{{ $item->product->name }}"
                                                class="w-12 h-12 rounded-md object-cover shadow-sm">
                                        @else
                                            <div
                                                class="w-12 h-12 rounded-md bg-gray-100 flex items-center justify-center">
                                                <i class="fa fa-image text-gray-400 text-sm"></i>
                                            </div>
                                        @endif
                                        <span>{{ $item->product->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-3 text-sm text-center text-gray-800">
                                    {{ $item->quantity }}
                                </td>
                                <td class="px-6 py-3 text-sm text-right text-gray-700">
                                    ${{ number_format($item->unit_price, 2) }}
                                </td>
                                <td class="px-6 py-3 text-sm text-right font-semibold text-gray-900">
                                    ${{ number_format($item->total_price, 2) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Order Trails --}}
        @if ($order->trails->count())
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Order History</h3>

                <div class="relative">
                    <div class="absolute left-12 top-0 bottom-0 w-0.5 bg-blue-200"></div>
                    <ul class="space-y-4">
                        @foreach ($order->trails as $trail)
                            @php
                                $statusLabel = match ($trail->status) {
                                    'pending' => 'Order placed',
                                    'confirmed' => 'Order confirmed',
                                    'delivered' => 'Order delivered',
                                    'completed' => 'Order completed',
                                    'cancelled' => 'Order cancelled',
                                    default => ucfirst($trail->status),
                                };
                                $roleName = optional($trail->user?->roles->first())->name ?? null;
                            @endphp
                            <li class="relative pl-12">
                                <div
                                    class="absolute left-0 top-0 w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center shadow-md">
                                    <i class="fa fa-check text-white text-xs"></i>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                    <div class="flex items-center justify-between mb-1">
                                        <h4 class="text-sm font-semibold text-gray-900">
                                            {{ $statusLabel }}
                                        </h4>
                                        <span class="text-xs text-gray-500">
                                            {{ $trail->created_at->format('d M Y — h:i A') }}
                                        </span>
                                    </div>
                                    <p class="text-sm text-gray-600">
                                        <span class="font-medium">By:</span>
                                        @if ($trail->user)
                                            {{ $roleName ? ucfirst($roleName) . ' — ' : '' }}{{ $trail->user->name }}
                                        @else
                                            System
                                        @endif
                                    </p>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
    @endif
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
    </script>
@endpush