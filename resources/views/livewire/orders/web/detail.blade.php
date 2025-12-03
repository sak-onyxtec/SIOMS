<div class="container mx-auto px-6 py-10">
    {{-- Back Button --}}
    <div class="mb-6 scroll-fade-in">
        <a href="{{ route('orders.web.listing') }}"
            class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-700 font-medium transition-colors duration-200 group">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Orders
        </a>
    </div>

    @if ($order)
        {{-- Order Summary Card --}}
        <div class="bg-white rounded-xl shadow-lg p-6 mb-6 border border-gray-100 scroll-fade-in">
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-2xl font-bold text-gray-800 mb-4">Order Details</h1>
                @php
                    $isRefunded = !is_null($order->refunded_at);
                @endphp
                {{-- Receipt / Refund Receipt Actions --}}
                @if(!is_null($order->paid_at))
                    <div class="mt-4 flex flex-wrap gap-3">
                        <a href="{{ route('orders.web.receipt', $order->id) }}"
                        class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white text-sm font-semibold rounded-lg hover:bg-emerald-700 transition-colors duration-200"
                        download>
                            <i class="fa fa-download mr-2"></i>
                            {{ $isRefunded ? 'Download Refund Receipt' : 'Download Receipt' }}
                        </a>
                    </div>
                @endif
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-4">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Order ID</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $order->uid }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 mb-1">Status</p>
                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full
                        @if($order->status === 'completed') bg-green-100 text-green-800
                        @elseif($order->status === 'pending') bg-yellow-100 text-yellow-800
                        @elseif($order->status === 'cancelled') bg-red-100 text-red-800
                        @else bg-gray-100 text-gray-800
                        @endif">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>
                <div>
                    <p class="text-sm text-gray-500 mb-1">Payment Status</p>
                    @php
                        $isPaid = !is_null($order->paid_at);
                    @endphp
                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full
                        {{ $isPaid ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        <i class="fa {{ $isPaid ? 'fa-check-circle' : 'fa-times-circle' }} mr-1 mt-1"></i>
                        {{ $isPaid ? 'Paid' : 'Not Paid' }}
                    </span>
                    @if($isPaid && $order->paid_at)
                        <p class="text-xs text-gray-500 mt-1">
                            {{ $order->paid_at->format('M d, Y') }}
                        </p>
                    @endif
                </div>
                @php
                    $isRefunded = !is_null($order->refunded_at);
                @endphp
                @if($isRefunded)
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Refund Status</p>
                        <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-orange-100 text-orange-800">
                            <i class="fa fa-undo mr-1 mt-1"></i>
                            Refunded
                        </span>
                        @if($order->refunded_at)
                            <p class="text-xs text-gray-500 mt-1">
                                {{ $order->refunded_at->format('M d, Y') }}
                            </p>
                        @endif
                    </div>
                @endif
                <div>
                    <p class="text-sm text-gray-500 mb-1">Total Amount</p>
                    <p class="text-lg font-semibold text-blue-600">${{ number_format($order->total, 2) }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 mb-1">Order Date</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $order->created_at->format('M d, Y') }}</p>
                </div>
            </div>
        </div>

        {{-- Order Items Card --}}
        <div class="bg-white rounded-xl shadow-lg p-6 mb-6 border border-gray-100 scroll-fade-in">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Order Items</h2>
            <div class="">
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-blue-50 to-blue-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Product</th>
                            <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Quantity</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Unit Price</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Total Price</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($order->items as $item)
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        @if($item->product && $item->product->product_image)
                                            <img src="{{ $item->product->product_image }}" alt="{{ $item->product->name }}" 
                                                class="h-12 w-12 rounded-lg object-cover mr-4">
                                        @endif
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ $item->product->name ?? 'N/A' }}</p>
                                            @if($item->product && $item->product->sku)
                                                <p class="text-xs text-gray-500">SKU: {{ $item->product->sku }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="text-sm text-gray-900 font-medium">{{ $item->quantity }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <span class="text-sm text-gray-900">${{ number_format($item->unit_price, 2) }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <span class="text-sm font-semibold text-gray-900">${{ number_format($item->total_price, 2) }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gradient-to-r from-blue-50 to-blue-100">
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-right text-sm font-semibold text-gray-700">Total:</td>
                            <td class="px-6 py-4 text-right text-lg font-bold text-blue-600">${{ number_format($order->total, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        {{-- Order History/Trail Card --}}
        @if ($order->trails->count())
            <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100 scroll-fade-in">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Order History</h2>
                <div class="relative">
                    <div class="absolute left-4 top-0 bottom-0 w-0.5 bg-blue-200"></div>
                    <ul class="space-y-6">
                        @foreach ($order->trails as $trail)
                            <li class="relative pl-12">
                                <div class="absolute left-0 top-0 w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center shadow-md">
                                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                    <div class="flex items-center justify-between mb-2">
                                        <h3 class="text-sm font-semibold text-gray-900">
                                            @if($trail->status === 'pending')
                                                Order Placed
                                            @else
                                                {{ ucfirst($trail->status) }}
                                            @endif
                                        </h3>
                                        <span class="text-xs text-gray-500">{{ $trail->created_at->format('M d, Y h:i A') }}</span>
                                    </div>
                                    <p class="text-sm text-gray-600">
                                        <span class="font-medium">Updated by:</span>
                                        @if($trail->user)
                                            @php
                                                $userRole = $trail->user->getRoleNames()->first() ?? 'User';
                                            @endphp
                                            <span class="capitalize">{{ $userRole }}</span> - {{ $trail->user->name }}
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
