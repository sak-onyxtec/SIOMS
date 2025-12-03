<div class="p-6 space-y-6">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 mb-1">
                Customer Detail
            </h2>
            <p class="text-sm text-gray-500">
                View profile information and recent orders for this customer.
            </p>
        </div>
        <a href="{{ route('customers.index') }}"
           class="inline-flex items-center px-3 py-1.5 no-underline rounded-full text-xs font-semibold text-gray-700 bg-gray-100 hover:bg-gray-200 border border-gray-200 transition-colors duration-200">
            <i class="fas fa-arrow-left mr-1.5"></i> Back to Customers
        </a>
    </div>

    {{-- Top summary --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="md:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 p-5 flex items-center gap-4">
            <div class="w-14 h-14 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 text-xl font-semibold">
                {{ strtoupper(substr($customer->name ?? 'U', 0, 1)) }}
            </div>
            <div>
                <p class="text-sm font-semibold text-gray-900">{{ $customer->name }}</p>
                <p class="text-sm text-gray-600">{{ $customer->email }}</p>
                <p class="text-xs text-gray-400 mt-1">Joined {{ $customer->created_at->format('M d, Y') }}</p>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 flex flex-col justify-center">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Total Orders</p>
            <p class="text-3xl font-bold text-gray-900">{{ $customer->orders_count ?? 0 }}</p>
        </div>
    </div>

    {{-- Tabs --}}
    <div x-data="{ tab: 'profile' }" class="space-y-4">
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex gap-6 text-sm font-medium">
                <button
                    type="button"
                    @click="tab = 'profile'"
                    :class="tab === 'profile'
                        ? 'border-blue-500 text-blue-600'
                        : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                    class="pb-2 border-b-2 transition-colors duration-150">
                    Profile
                </button>
                <button
                    type="button"
                    @click="tab = 'orders'"
                    :class="tab === 'orders'
                        ? 'border-blue-500 text-blue-600'
                        : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                    class="pb-2 border-b-2 transition-colors duration-150">
                    Orders <span class="ml-1 text-xs text-gray-400">({{ $customer->orders_count ?? 0 }})</span>
                </button>
            </nav>
        </div>

        {{-- Profile tab --}}
        <div x-show="tab === 'profile'" x-cloak class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase mb-1">Name</p>
                    <p class="text-sm text-gray-900">{{ $customer->name }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase mb-1">Email</p>
                    <p class="text-sm text-gray-900">{{ $customer->email }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase mb-1">Status</p>
                    <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold
                        {{ $customer->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $customer->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase mb-1">Joined</p>
                    <p class="text-sm text-gray-900">{{ $customer->created_at->format('d M Y, h:i A') }}</p>
                </div>
            </div>
        </div>

        {{-- Orders tab --}}
        <div x-show="tab === 'orders'" x-cloak class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            @if($orders->isEmpty())
                <div class="py-8 text-center text-sm text-gray-500">
                    This customer has no orders yet.
                </div>
            @else
                <div class="mb-3 flex items-center justify-between">
                    <h3 class="text-sm font-semibold text-gray-800">
                        Latest Orders ({{ $orders->count() }})
                    </h3>
                </div>

                <div class="">
                    <table class="min-w-full text-sm">
                        <thead>
                        <tr class="bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-wide">
                            <th class="px-4 py-2 text-left">Order ID</th>
                            <th class="px-4 py-2 text-left">Date</th>
                            <th class="px-4 py-2 text-left">Status</th>
                            <th class="px-4 py-2 text-right">Total</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                        @foreach($orders as $order)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2 font-semibold text-gray-900">
                                    #{{ $order->uid }}
                                </td>
                                <td class="px-4 py-2 text-gray-700">
                                    {{ $order->created_at->format('d M Y, h:i A') }}
                                </td>
                                <td class="px-4 py-2">
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
                                    <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold {{ $badgeClasses }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-2 text-right text-gray-900 font-semibold">
                                    ${{ number_format($order->total, 2) }}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>


