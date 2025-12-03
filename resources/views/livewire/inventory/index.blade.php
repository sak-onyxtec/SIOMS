<div class="p-6">

    @if (session()->has('success'))
        <div class="mb-4 rounded-lg border border-green-100 bg-green-50 px-4 py-3 text-sm text-green-800">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-gray-800">
            Inventory Transactions
        </h2>

        <button wire:click="$set('showModal', true)"
                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg shadow-md hover:bg-blue-700 hover:shadow-lg transition-all duration-200">
            <i class="fas fa-plus mr-2"></i> New Transaction
        </button>
    </div>

    {{-- Filters --}}
    <div class="mb-4 flex flex-col sm:flex-row gap-4 items-end">
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Filter by Product</label>
            <select id="inventory-filter-product"
                    class="w-64 max-w-xs px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                <option value="">All Products</option>
                @foreach ($products as $product)
                    <option value="{{ $product->name }}">{{ $product->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Filter by Type</label>
            <select id="inventory-filter-type"
                    class="w-64 max-w-xs px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                <option value="">All Types</option>
                <option value="Stock In">Stock In</option>
                <option value="Stock Out">Stock Out</option>
                <option value="Adjustment">Adjustment</option>
            </select>
        </div>

        <button
            id="inventory-clear-filters"
            type="button"
            class="relative inline-flex items-center px-3 py-2 text-md font-semibold text-red-600 hover:text-red-800 bg-red-50 hover:bg-red-100 rounded-lg border border-red-100 shadow-sm hidden">
            <span class="absolute -top-1 -right-1 inline-flex h-2.5 w-2.5 rounded-full bg-red-500"></span>
            Clear filters
        </button>
    </div>

    {{-- Transactions Table --}}
    <div class="bg-white mt-4">
        <div wire:ignore>
            <table class="w-full js-datatable" id="inventory-table">
                <thead>
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            <button wire:click="sortByColumn('id')" class="flex items-center gap-1 hover:text-blue-700 transition-colors duration-200 group">
                                ID
                                <!-- <div class="flex flex-col">
                                    <svg class="w-3 h-3 {{ $sortBy === 'id' && $sortDirection === 'asc' ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-600' }}" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                    <svg class="w-3 h-3 -mt-1 {{ $sortBy === 'id' && $sortDirection === 'desc' ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-600' }}" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                </div> -->
                            </button>
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            <button wire:click="sortByColumn('type')" class="flex items-center gap-1 hover:text-blue-700 transition-colors duration-200 group">
                                Type
                                <!-- <div class="flex flex-col">
                                    <svg class="w-3 h-3 {{ $sortBy === 'type' && $sortDirection === 'asc' ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-600' }}" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                    <svg class="w-3 h-3 -mt-1 {{ $sortBy === 'type' && $sortDirection === 'desc' ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-600' }}" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                </div> -->
                            </button>
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            <button wire:click="sortByColumn('quantity')" class="flex items-center gap-1 hover:text-blue-700 transition-colors duration-200 group">
                                Quantity
                                <!-- <div class="flex flex-col">
                                    <svg class="w-3 h-3 {{ $sortBy === 'quantity' && $sortDirection === 'asc' ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-600' }}" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                    <svg class="w-3 h-3 -mt-1 {{ $sortBy === 'quantity' && $sortDirection === 'desc' ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-600' }}" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                </div> -->
                            </button>
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">User</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Product</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Notes</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            <button wire:click="sortByColumn('created_at')" class="flex items-center gap-1 hover:text-blue-700 transition-colors duration-200 group">
                                Date
                                <div class="flex flex-col">
                                    <!-- <svg class="w-3 h-3 {{ $sortBy === 'created_at' && $sortDirection === 'asc' ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-600' }}" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                    <svg class="w-3 h-3 -mt-1 {{ $sortBy === 'created_at' && $sortDirection === 'desc' ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-600' }}" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg> -->
                                </div>
                            </button>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($transactions as $transaction)
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $transaction->id }}</td>
                            <td class="px-4 py-3 text-sm">
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                    @if($transaction->type === 'stock_in') bg-green-100 text-green-800
                                    @elseif($transaction->type === 'stock_out') bg-red-100 text-red-800
                                    @else bg-yellow-100 text-yellow-800
                                    @endif">
                                    {{ ucfirst(str_replace('_', ' ', $transaction->type)) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-sm font-semibold text-gray-900">{{ $transaction->quantity }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $transaction->user?->name ?? 'System' }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $transaction->product?->name ?? '-' }}</td>
                            <td class="px-4 py-3 text-sm truncate text-gray-600">{{ $transaction->notes ?? '-' }}</td>
                            <td class="px-4 py-3 text-sm text-gray-500">
                                {{ $transaction->created_at->format('M d, Y h:i A') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-12 text-center">
                                <div class="text-gray-500">
                                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4-4 4 4m4-10l-4 4-4-4"></path>
                                    </svg>
                                    <p class="text-lg font-medium">No transactions found</p>
                                    <p class="text-sm mt-1">Click “New Transaction” to add stock movements.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Modal for New Transaction --}}
    @if($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-30 backdrop-blur-sm">
            <div class="bg-white rounded-xl shadow-2xl border border-gray-100 w-full max-w-lg">
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">New Inventory Transaction</h3>
                    <button wire:click="$set('showModal', false)" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <div class="px-6 py-4 space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Product</label>
                        <select wire:model="product_id"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                            <option value="">Select Product</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }} (Stock: {{ $product->quantity }})</option>
                            @endforeach
                        </select>
                        @error('product_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Type</label>
                        <select wire:model="type"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                            <option value="">Select Type</option>
                            <option value="stock_in">Stock In</option>
                            <option value="stock_out">Stock Out</option>
                            <option value="adjustment">Adjustment</option>
                        </select>
                        @error('type') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Quantity</label>
                        <input type="number"
                               wire:model.live.debounce.300ms="quantity"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none @error('quantity') border-red-500 @enderror"
                               min="1"
                               max="999999">
                        @error('quantity') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Notes</label>
                        <textarea wire:model="notes"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
                                  rows="3"></textarea>
                        @error('notes') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="flex justify-end items-center px-6 py-4 border-t border-gray-200 bg-gray-50 gap-3">
                    <button wire:click="$set('showModal', false)"
                            class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 font-semibold hover:bg-white transition-colors duration-200">
                        Cancel
                    </button>
                    <button wire:click="saveTransaction"
                            class="px-5 py-2 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition-colors duration-200">
                        Save
                    </button>
                </div>
            </div>
        </div>
    @endif

</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const productFilter = $('#inventory-filter-product');
        const typeFilter = $('#inventory-filter-type');
        const clearBtn = $('#inventory-clear-filters');

        function updateClearVisibility() {
            if (productFilter.val() || typeFilter.val()) {
                clearBtn.removeClass('hidden');
            } else {
                clearBtn.addClass('hidden');
            }
        }

        productFilter.on('change.invFilters', updateClearVisibility);
        typeFilter.on('change.invFilters', updateClearVisibility);

        clearBtn.on('click', function () {
            productFilter.val('');
            typeFilter.val('');
            productFilter.trigger('change');
            typeFilter.trigger('change');
            updateClearVisibility();
        });

        // Initialize visibility on first load
        updateClearVisibility();
    });

</script>
@endpush
