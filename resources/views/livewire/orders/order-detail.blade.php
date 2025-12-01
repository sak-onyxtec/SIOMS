<div class="max-full mx-auto p-4">

    {{-- Back Button --}}
    <div class="mb-4">
        <a href="{{ Auth::user()->hasRole('customer') ? route('orders.my') : route('orders.index') }}"
            class="inline-block px-4 no-underline py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">
            <i class="fa fa-arrow-left"></i> Back to Orders
        </a>
    </div>
    @if ($order)

        {{-- Order Summary --}}
        <div class="bg-gray-100 p-4 rounded mb-6">
            <p><strong>Order ID:</strong> {{ $order->uid }}</p>
            <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
            <p><strong>Total:</strong> ${{ number_format($order->total, 2) }}</p>
            <p><strong>Date:</strong> {{ $order->created_at->format('d M Y') }}</p>
        </div>

        {{-- Items Table --}}
        <table class="w-full table-auto border-collapse mb-6">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border px-4 py-2 text-left">Product</th>
                    <th class="border px-4 py-2 text-center">Quantity</th>
                    <th class="border px-4 py-2 text-right">Unit Price</th>
                    <th class="border px-4 py-2 text-right">TotalPrice</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->items as $item)
                    <tr>
                        <td class="border px-4 py-2">{{ $item->product->name }}</td>
                        <td class="border px-4 py-2 text-center">{{ $item->quantity }}</td>
                        <td class="border px-4 py-2 text-right">${{ $item->unit_price }}</td>
                        <td class="border px-4 py-2 text-right">${{ $item->total_price }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Order Trails --}}
        @if ($order->trails->count())
            <div class="mt-6">
                <h4 class="font-semibold mb-3">Order History</h4>

                <ul class="timeline list-unstyled position-relative">
                    @foreach ($order->trails as $trail)
                        <li class="mb-4 position-relative ps-5">
                            <span class="position-absolute top-0 start-0 translate-middle bg-blue-500 rounded-circle"
                                style="width:14px; height:14px;"></span>

                            <div class="p-3 border rounded shadow-sm bg-gray-100">
                                <h6 class="mb-1">{{ ucfirst($trail->status) }}</h6>
                                <p class="mb-1 text-muted">
                                    <strong>User:</strong>
                                    {{ $trail->user ? (Auth::id() == $trail->user->id ? 'You' : $trail->user->name) : 'System' }}
                                </p>
                                <small class="text-gray-500">
                                    {{ $trail->created_at->format('d M Y — h:i A') }}
                                </small>
                            </div>
                        </li>
                    @endforeach

                    {{-- Vertical line --}}
                    <div class="position-absolute top-0 start-0 bg-blue-500" style="width:3px; height:100%; left:6px;">
                    </div>
                </ul>
            </div>
        @endif
    @endif
</div>
