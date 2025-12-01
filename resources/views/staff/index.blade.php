<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Staffs') }}
        </h2>
    </x-slot>

    {{-- <div class="py-12">
        <div class="max-w-full sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Search Form -->
                   <div class="mb-4">
                        <form method="GET" action="{{ route('product.index') }}" class="flex items-center justify-end space-x-4">
                            <input 
                                type="text" 
                                name="search" 
                                value="{{ request('search') }}" 
                                class="form-input rounded-md shadow-sm h-12 px-4 w-96" 
                                placeholder="Search"
                            >
                            <button type="submit" class="btn btn-success h-12 px-6">Search</button>
                        </form>
                    </div>

                    <!-- Add Product Button -->
                    @can('create-products')
                    <div class="mb-4">
                        <a href="{{ route('product.create') }}" class="btn btn-success">
                            Add Product
                        </a>
                    </div>
                    @endcan

                    <!-- Products Table -->
                    <table class="min-w-full bg-white dark:bg-gray-800 rounded-md shadow-md w-full" id="myTable">
                        <thead>
                            <tr class="text-left border-b dark:border-gray-600">
                                <th class="px-4 py-2">Name</th>
                                <th class="px-4 py-2">SKU</th>
                                <th class="px-4 py-2">Category</th>
                                <th class="px-4 py-2">Quantity</th>
                                <th class="px-4 py-2">Price</th>
                                <th class="px-4 py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr class="border-b dark:border-gray-600">
                                    <td class="px-4 py-2">{{ $product->name }}</td>
                                    <td class="px-4 py-2">{{ $product->sku }}</td>
                                    <td class="px-4 py-2">{{ $product->category }}</td>
                                    <td class="px-4 py-2">{{ $product->quantity }}</td>
                                    <td class="px-4 py-2">${{ number_format($product->price, 2) }}</td>
                                    <td class="px-4 py-2">
                                        <!-- Edit Action -->
                                        @can('edit-products')
                                        <a href="{{ route('product.edit', ['id'=>$product->id]) }}" class="btn btn-info"><i class="fa fa-pencil"></i></a>
                                        @endcan
                                        
                                        <!-- Delete Action -->
                                        @can('delete-products')
                                            <form action="{{ route('product.destroy', ['id'=>$product->id]) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger"><i class="fa fa-delete"></i></button>
                                            </form>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    <div class="py-12">
        <div class="max-w-full sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <livewire:staffs.index />
            </div>
        </div>
    </div>
</x-app-layout>
