<div class="p-6">
    {{-- Back Button --}}
    <div class="mb-6">
        <a href="{{ route('product.index') }}" class="inline-flex items-center gap-2 no-underline text-gray-600 hover:text-gray-800 font-medium transition-colors duration-200">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Products
        </a>
    </div>

    @if($product)
        {{-- Product Details Card --}}
        <div class="bg-white rounded-xl shadow-lg p-6 mb-6 border border-gray-100">
            <div class="flex flex-col lg:flex-row gap-6">
                {{-- Product Image --}}
                <div class="lg:w-1/3">
                    @if($product->product_image)
                        <img src="{{ $product->product_image }}" alt="{{ $product->name }}" 
                            class="w-full h-64 object-cover rounded-lg shadow-md">
                    @else
                        <div class="w-full h-64 bg-gray-100 rounded-lg flex items-center justify-center">
                            <svg class="w-24 h-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    @endif
                </div>

                {{-- Product Information --}}
                <div class="lg:w-2/3">
                    <h1 class="text-3xl font-bold text-gray-800 mb-4">{{ $product->name }}</h1>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">SKU</p>
                            <p class="text-lg font-semibold text-gray-800">{{ $product->sku }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Category</p>
                            <p class="text-lg font-semibold text-gray-800">{{ optional($product->category)->name ?? 'Uncategorized' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Quantity</p>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold
                                {{ $product->quantity <= 5 ? 'bg-red-100 text-red-800' : ($product->quantity <= 10 ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">
                                {{ $product->quantity }} units
                            </span>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Price</p>
                            <p class="text-2xl font-bold text-blue-600">${{ number_format($product->price, 2) }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Total Stock Value</p>
                            <p class="text-lg font-semibold text-gray-800">${{ number_format($product->price * $product->quantity, 2) }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Created At</p>
                            <p class="text-lg font-semibold text-gray-800">{{ $product->created_at->format('M d, Y h:i A') }}</p>
                        </div>
                    </div>

                    <div class="mt-6 flex gap-3">
                        @can('edit-products')
                            <a href="{{ route('product.edit', $product->id) }}" 
                                class="px-4 py-2 bg-blue-600 text-white no-underline rounded-lg hover:bg-blue-700 transition-colors duration-200 font-semibold">
                                <i class="fas fa-edit mr-2"></i>Edit Product
                            </a>
                        @endcan
                    </div>
                </div>
            </div>
        </div>

        {{-- Tabs for Change Logs, Images and Inventory Transactions --}}
        <div class="bg-white rounded-xl shadow-lg border border-gray-100">
            {{-- Tab Navigation --}}
            <div class="border-b border-gray-200">
                <nav class="flex -mb-px">
                    <button onclick="showTab('images')" id="imagesTab" 
                    class="px-6 py-4 text-sm font-semibold text-gray-500 hover:text-gray-700 border-b-2 border-transparent hover:border-gray-300">
                        <i class="fas fa-images mr-2"></i>Images ({{ $product->images->count() }})
                    </button>
                    <button onclick="showTab('changeLogs')" id="changeLogsTab" 
                        class="px-6 py-4 text-sm font-semibold text-blue-600 border-b-2 border-blue-600">
                        <i class="fas fa-history mr-2"></i>Change Logs ({{ $changeLogs->count() }})
                    </button>
                    <button onclick="showTab('transactions')" id="transactionsTab" 
                        class="px-6 py-4 text-sm font-semibold text-gray-500 hover:text-gray-700 border-b-2 border-transparent hover:border-gray-300">
                        <i class="fas fa-exchange-alt mr-2"></i>Inventory Transactions ({{ $transactions->count() }})
                    </button>
                </nav>
            </div>

            {{-- Tab Content --}}
            <div class="p-6">
                {{-- Change Logs Tab --}}
                <div id="changeLogsContent" class="tab-content">
                    @if($changeLogs->count())
                        <div class="relative">
                            <div class="absolute left-12 top-0 bottom-0 w-0.5 bg-blue-200"></div>
                            <ul class="space-y-6">
                                @foreach($changeLogs as $log)
                                    <li class="relative pl-12">
                                    <div class="absolute left-0 top-0 w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center shadow-md">
                                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                            <div class="flex items-center justify-between mb-2">
                                                <h3 class="text-sm font-semibold text-gray-900">
                                                    {{ ucfirst($log->action) }}
                                                </h3>
                                                <span class="text-xs text-gray-500">{{ $log->created_at->format('M d, Y h:i A') }}</span>
                                            </div>
                                            <p class="text-sm text-gray-600 mb-2">
                                                <span class="font-medium">By:</span>
                                                @if($log->user)
                                                    @php
                                                        $roleName = optional($log->user->roles->first())->name ?? null;
                                                    @endphp
                                                    {{ $roleName ? ucfirst($roleName) . ' — ' : '' }}{{ $log->user->name }}
                                                @else
                                                    System
                                                @endif
                                            </p>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="text-gray-500 text-lg">No change logs found for this product.</p>
                        </div>
                    @endif
                </div>

                {{-- Images Tab --}}
                <div id="imagesContent" class="tab-content hidden">
                    @if($product->images->count())
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            @foreach($product->images as $image)
                                <div class="border border-gray-200 rounded-lg overflow-hidden shadow-sm bg-white">
                                    <img src="{{ $image->image_url }}" alt="Product Image"
                                         class="w-full h-40 object-cover">
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <p class="text-gray-500 text-lg">No additional images found for this product.</p>
                        </div>
                    @endif
                </div>

                {{-- Inventory Transactions Tab --}}
                <div id="transactionsContent" class="tab-content hidden">
                    @if($transactions->count())
                        <div class="">
                            <table class="w-full">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Type</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Quantity</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">User</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Notes</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Date</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($transactions as $transaction)
                                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                                            <td class="px-4 py-3 whitespace-nowrap">
                                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                                    @if($transaction->type === 'stock_in') bg-green-100 text-green-800
                                                    @elseif($transaction->type === 'stock_out') bg-red-100 text-red-800
                                                    @else bg-yellow-100 text-yellow-800
                                                    @endif">
                                                    {{ ucfirst(str_replace('_', ' ', $transaction->type)) }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap">
                                                <span class="text-sm font-semibold text-gray-900">{{ $transaction->quantity }}</span>
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap">
                                                <span class="text-sm text-gray-600">{{ $transaction->user->name ?? 'System' }}</span>
                                            </td>
                                            <td class="px-4 py-3">
                                                <span class="text-sm text-gray-600">{{ $transaction->notes ?? '-' }}</span>
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                                {{ $transaction->created_at->format('M d, Y h:i A') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <p class="text-gray-500 text-lg">No inventory transactions found for this product.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>

<script>
    function showTab(tabName) {
        // Hide all tab contents
        document.getElementById('changeLogsContent').classList.add('hidden');
        document.getElementById('imagesContent').classList.add('hidden');
        document.getElementById('transactionsContent').classList.add('hidden');
        
        // Remove active styles from all tabs
        document.getElementById('changeLogsTab').classList.remove('text-blue-600', 'border-blue-600');
        document.getElementById('changeLogsTab').classList.add('text-gray-500', 'border-transparent');
        document.getElementById('imagesTab').classList.remove('text-blue-600', 'border-blue-600');
        document.getElementById('imagesTab').classList.add('text-gray-500', 'border-transparent');
        document.getElementById('transactionsTab').classList.remove('text-blue-600', 'border-blue-600');
        document.getElementById('transactionsTab').classList.add('text-gray-500', 'border-transparent');
        
        // Show selected tab content
        document.getElementById(tabName + 'Content').classList.remove('hidden');
        
        // Add active styles to selected tab
        document.getElementById(tabName + 'Tab').classList.remove('text-gray-500', 'border-transparent');
        document.getElementById(tabName + 'Tab').classList.add('text-blue-600', 'border-blue-600');
    }
</script>

