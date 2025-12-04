<div class="p-6">
    @if(session('success'))
        <div id="success-alert" class="alert alert-success d-flex align-items-center shadow-sm" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div id="error-alert" class="alert alert-danger d-flex align-items-center shadow-sm" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            {{ session('error') }}
        </div>
    @endif

    <div class="mb-6 d-flex justify-content-between align-items-center">
        <h2 class="text-2xl font-bold text-gray-800 mb-0">Categories</h2>

        <a href="{{ route('category.create') }}" class="btn btn-success shadow-sm">
            <i class="fas fa-plus me-2"></i> Add Category
        </a>
    </div>

    {{-- Search handled by DataTable --}}

    <div class="bg-white">
        <div class="">
            <table class="w-full js-datatable">
                <thead>
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        <button wire:click="sortByColumn('name')" class="flex items-center gap-1 hover:text-blue-700 transition-colors duration-200 group">
                            Name
                            <div class="flex flex-col">
                                <svg class="w-3 h-3 {{ $sortBy === 'name' && $sortDirection === 'asc' ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-600' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                                </svg>
                                <svg class="w-3 h-3 -mt-1 {{ $sortBy === 'name' && $sortDirection === 'desc' ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-600' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </button>
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        <button wire:click="sortByColumn('slug')" class="flex items-center gap-1 hover:text-blue-700 transition-colors duration-200 group">
                            Slug
                            <div class="flex flex-col">
                                <svg class="w-3 h-3 {{ $sortBy === 'slug' && $sortDirection === 'asc' ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-600' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                                </svg>
                                <svg class="w-3 h-3 -mt-1 {{ $sortBy === 'slug' && $sortDirection === 'desc' ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-600' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </button>
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        <button wire:click="sortByColumn('products_count')" class="flex items-center gap-1 hover:text-blue-700 transition-colors duration-200 group">
                            Products
                            <div class="flex flex-col">
                                <svg class="w-3 h-3 {{ $sortBy === 'products_count' && $sortDirection === 'asc' ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-600' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                                </svg>
                                <svg class="w-3 h-3 -mt-1 {{ $sortBy === 'products_count' && $sortDirection === 'desc' ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-600' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </button>
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Status
                    </th>
                    <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider w-40">
                        Actions
                    </th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                @forelse($categories as $category)
                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm font-semibold text-gray-900">{{ $category->name }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm text-gray-700">{{ $category->slug }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm text-gray-700">{{ $category->products_count }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                {{ $category->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $category->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('category.edit', $category->id) }}"
                                   class="text-blue-600 hover:text-blue-700 font-semibold transition-colors duration-200"
                                   title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button"
                                        class="text-red-600 hover:text-red-700 font-semibold transition-colors duration-200"
                                        onclick="confirmCategoryDelete({{ $category->id }})"
                                        title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <button type="button"
                                        class="{{ $category->is_active ? 'text-yellow-600 hover:text-yellow-700' : 'text-green-600 hover:text-green-700' }} font-semibold transition-colors duration-200"
                                        wire:click="toggleActive({{ $category->id }})"
                                        title="{{ $category->is_active ? 'Deactivate' : 'Activate' }}">
                                    @if($category->is_active)
                                        <i class="fas fa-ban"></i>
                                    @else
                                        <i class="fas fa-check-circle"></i>
                                    @endif
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center">
                            <div class="text-gray-500">
                                <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <p class="text-lg font-medium">No categories found</p>
                                <p class="text-sm mt-1">Try adjusting your search or add a new category.</p>
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
        function confirmCategoryDelete(id) {
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
                        'Category has been deleted.',
                        'success'
                    );
                }
            })
        }

        // Auto-hide alerts after 3 seconds
        function autoHideAlerts() {
            const successAlert = document.getElementById('success-alert');
            const errorAlert = document.getElementById('error-alert');

            if (successAlert && !successAlert.dataset.hideScheduled) {
                successAlert.dataset.hideScheduled = 'true';
                setTimeout(() => {
                    successAlert.style.transition = 'opacity 0.5s ease-out';
                    successAlert.style.opacity = '0';
                    setTimeout(() => {
                        successAlert.remove();
                    }, 500);
                }, 3000);
            }

            if (errorAlert && !errorAlert.dataset.hideScheduled) {
                errorAlert.dataset.hideScheduled = 'true';
                setTimeout(() => {
                    errorAlert.style.transition = 'opacity 0.5s ease-out';
                    errorAlert.style.opacity = '0';
                    setTimeout(() => {
                        errorAlert.remove();
                    }, 500);
                }, 3000);
            }
        }

        // Run on page load
        document.addEventListener('DOMContentLoaded', autoHideAlerts);

        // Run after Livewire updates
        if (typeof Livewire !== 'undefined') {
            Livewire.hook('message.processed', () => {
                setTimeout(autoHideAlerts, 100);
            });
        }
    </script>
@endpush


