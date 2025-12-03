<div class="p-6">

    <div class="mb-6 d-flex justify-content-between align-items-center">
        @if($lowStock)
            <div class="alert alert-warning d-flex align-items-center shadow-sm" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <div>
                    Showing Low Stock Items (Quantity ≤ 5)
                    <a href="{{ route('product.index') }}" class="alert-link ms-2 fw-bold">View All Products</a>
                </div>
            </div>
        @else
            <h2 class="text-2xl font-bold text-gray-800 mb-0">Products</h2>
        @endif

        @can('create-products')
            <a href="{{ route('product.create') }}" class="btn btn-success shadow-sm">
                <i class="fas fa-plus me-2"></i> Add Product
            </a>
        @endcan
    </div>

    {{-- Search --}}
    <!-- <div class="mb-4">
        <input type="text" wire:model.live.debounce.300ms="search" 
            placeholder="Search by name, SKU, or category..."
            class="w-full max-w-md px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-300 shadow-sm hover:shadow-md">
    </div> -->

    <div class="bg-white">
        <div class="">
            <table class="w-full js-datatable">
                <thead class="">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            <button wire:click="sortByColumn('name')" class="flex items-center gap-1 hover:text-blue-700 transition-colors duration-200 group">
                                Product
                                <!-- <div class="flex flex-col">
                                    <svg class="w-3 h-3 {{ $sortBy === 'name' && $sortDirection === 'asc' ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-600' }}" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                    <svg class="w-3 h-3 -mt-1 {{ $sortBy === 'name' && $sortDirection === 'desc' ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-600' }}" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                </div> -->
                            </button>
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            <button wire:click="sortByColumn('sku')" class="flex items-center gap-1 hover:text-blue-700 transition-colors duration-200 group">
                                SKU
                                <!-- <div class="flex flex-col">
                                    <svg class="w-3 h-3 {{ $sortBy === 'sku' && $sortDirection === 'asc' ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-600' }}" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                    <svg class="w-3 h-3 -mt-1 {{ $sortBy === 'sku' && $sortDirection === 'desc' ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-600' }}" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                </div> -->
                            </button>
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Category</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
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
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            <button wire:click="sortByColumn('price')" class="flex items-center gap-1 hover:text-blue-700 transition-colors duration-200 group">
                                Price
                                <!-- <div class="flex flex-col">
                                    <svg class="w-3 h-3 {{ $sortBy === 'price' && $sortDirection === 'asc' ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-600' }}" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                    <svg class="w-3 h-3 -mt-1 {{ $sortBy === 'price' && $sortDirection === 'desc' ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-600' }}" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                </div> -->
                            </button>
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider text-center w-32">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($products as $p)
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    @if ($p->product_image)
                                        <img src="{{ $p->product_image }}" class="rounded shadow-sm" width="60" height="60" style="object-fit: cover; flex-shrink: 0;">
                                    @else
                                        <div class="bg-gray-100 rounded flex items-center justify-center shadow-sm" style="width: 60px; height: 60px; flex-shrink: 0;">
                                            <i class="fas fa-image text-gray-400"></i>
                                        </div>
                                    @endif
                                    <div class="font-semibold text-gray-800 max-w-xs">
                                        <span class="block truncate" title="{{ $p->name }}">
                                            {{ $p->name }}
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-semibold rounded bg-gray-200 text-gray-800 max-w-[8rem] inline-block truncate"
                                      title="{{ $p->sku }}">
                                    {{ $p->sku }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm text-gray-600">{{ optional($p->category)->name ?? '-' }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                    {{ $p->quantity <= 5 ? 'bg-red-100 text-red-800' : ($p->quantity <= 10 ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">
                                    {{ $p->quantity }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-bold text-blue-600">${{ number_format($p->price, 2) }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center">
                                <div class="flex justify-center gap-2">
                                    <a href="{{ route('product.view', $p->id) }}" title="View Details" 
                                        class="text-blue-600 no-underline hover:text-blue-700 font-semibold inline-flex items-center gap-1 transition-colors duration-200 group">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @can('edit-products')
                                        <a href="{{ route('product.edit', $p->id) }}" title="Edit" wire:key="edit-{{ $p->id }}"
                                            class="text-blue-600 no-underline hover:text-blue-700 font-semibold transition-colors duration-200">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    @endcan
                                    @can('delete-products')
                                        <button type="button" title="Delete" class="text-red-600 hover:text-red-700 font-semibold transition-colors duration-200"
                                            onclick="confirmDelete({{ $p->id }})">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="text-gray-500">
                                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                    <p class="text-lg font-medium">No products found</p>
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
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.call('delete', id);
                    Swal.fire(
                        'Deleted!',
                        'Product has been deleted.',
                        'success'
                    );
                }
            })
        }
    </script>
@endpush
