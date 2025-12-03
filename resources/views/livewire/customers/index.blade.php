<div class="p-6">

    @if (session()->has('success'))
        <div
            x-data="{ show: true }"
            x-show="show"
            x-init="setTimeout(() => show = false, 3000)"
            x-transition.opacity.duration.300ms
            class="mb-4 px-4 py-2 rounded-lg bg-green-50 text-green-800 text-sm border border-green-200">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-6 flex items-center justify-between">
        <h2 class="text-2xl font-bold text-gray-800 mb-0">Customers</h2>
        {{-- No "Add New" button for customers as requested --}}
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
                        <button wire:click="sortByColumn('email')" class="flex items-center gap-1 hover:text-blue-700 transition-colors duration-200 group">
                            Email
                            <div class="flex flex-col">
                                <svg class="w-3 h-3 {{ $sortBy === 'email' && $sortDirection === 'asc' ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-600' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                                </svg>
                                <svg class="w-3 h-3 -mt-1 {{ $sortBy === 'email' && $sortDirection === 'desc' ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-600' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </button>
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        <button wire:click="sortByColumn('created_at')" class="flex items-center gap-1 hover:text-blue-700 transition-colors duration-200 group">
                            Created At
                            <div class="flex flex-col">
                                <svg class="w-3 h-3 {{ $sortBy === 'created_at' && $sortDirection === 'asc' ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-600' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                                </svg>
                                <svg class="w-3 h-3 -mt-1 {{ $sortBy === 'created_at' && $sortDirection === 'desc' ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-600' }}" fill="currentColor" viewBox="0 0 20 20">
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
                @forelse($customers as $customer)
                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm font-semibold text-gray-900">{{ $customer->name }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm text-gray-700">{{ $customer->email }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm text-gray-600">{{ $customer->created_at->format('M d, Y') }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                {{ $customer->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $customer->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center">
                            <div class="flex items-center justify-center gap-3">
                                <a href="{{ route('customers.view', $customer->id) }}"
                                   class="inline-flex no-underline items-center px-3 py-1.5 rounded-full text-xs font-semibold text-blue-700 hover:text-blue-800 transition-colors duration-200">
                                    <i class="fas fa-eye mr-1.5"></i>
                                </a>

                                <button type="button"
                                        class="{{ $customer->is_active ? 'text-yellow-600 hover:text-yellow-700' : 'text-green-600 hover:text-green-700' }} font-semibold transition-colors duration-200"
                                        wire:click="toggleActive({{ $customer->id }})"
                                        title="{{ $customer->is_active ? 'Deactivate' : 'Activate' }}">
                                    @if($customer->is_active)
                                        <i class="fas fa-user-slash"></i>
                                    @else
                                        <i class="fas fa-user-check"></i>
                                    @endif
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="text-gray-500">
                                <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <p class="text-lg font-medium">No customers found</p>
                                <p class="text-sm mt-1">Try adjusting your search.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>


