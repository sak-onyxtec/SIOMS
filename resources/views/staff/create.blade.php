<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create Staff') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-full sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{-- <form method="POST" action="{{ route('staff.update', $staff->id) }}">
                        @csrf

                        <!-- Staff Name -->
                        <div class="mb-4">
                            <label for="name" class="block text-gray-700">Staff Name</label>
                            <input 
                                type="text" 
                                name="name" 
                                id="name" 
                                class="form-input rounded-md shadow-sm w-full" 
                                value="{{ old('name', $staff->name) }}" 
                                required
                            >
                        </div>

                        <!-- Staff SKU -->
                        <div class="mb-4">
                            <label for="sku" class="block text-gray-700">SKU</label>
                            <input 
                                type="text" 
                                name="sku" 
                                id="sku" 
                                class="form-input rounded-md shadow-sm w-full" 
                                value="{{ old('sku', $staff->sku) }}" 
                                required
                            >
                        </div>

                        <!-- Staff Category -->
                        <div class="mb-4">
                            <label for="category" class="block text-gray-700">Category</label>
                            <input 
                                type="text" 
                                name="category" 
                                id="category" 
                                class="form-input rounded-md shadow-sm w-full" 
                                value="{{ old('category', $staff->category) }}" 
                                required
                            >
                        </div>

                        <!-- Staff Quantity -->
                        <div class="mb-4">
                            <label for="quantity" class="block text-gray-700">Quantity</label>
                            <input 
                                type="number" 
                                name="quantity" 
                                id="quantity" 
                                class="form-input rounded-md shadow-sm w-full" 
                                value="{{ old('quantity', $staff->quantity) }}" 
                                required
                            >
                        </div>

                        <!-- Staff Price -->
                        <div class="mb-4">
                            <label for="price" class="block text-gray-700">Price</label>
                            <input 
                                type="number" 
                                name="price" 
                                id="price" 
                                class="form-input rounded-md shadow-sm w-full" 
                                value="{{ old('price', $staff->price) }}" 
                                required
                            >
                        </div>

                        <!-- Submit Button -->
                        <div>
                            <button type="submit" class="btn btn-info">Update Staff</button>
                        </div>
                    </form> --}}
                    <livewire:staffs.form />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
