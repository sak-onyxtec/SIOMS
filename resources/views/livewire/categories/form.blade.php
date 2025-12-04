<div class="max-w-full mx-auto p-6">
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
            <h2 class="text-2xl font-bold text-white">
                {{ $category_id ? 'Edit Category' : 'Create Category' }}
            </h2>
        </div>

        <form wire:submit.prevent="save" class="p-6 space-y-6">
            {{-- Name --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Category Name <span class="text-red-500">*</span>
                </label>
                <input type="text"
                       wire:model.live.debounce.300ms="name"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200 @error('name') border-red-500 @enderror"
                       placeholder="Enter category name"
                       maxlength="25">
                @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Buttons --}}
            <div class="flex justify-between items-center pt-6 border-t border-gray-200">
                <a wire:navigate
                   href="{{ route('category.index') }}"
                   class="px-6 py-3 no-underline border border-gray-300 rounded-lg text-gray-700 font-semibold hover:bg-gray-50 transition-colors duration-200">
                    <i class="fas fa-arrow-left mr-2"></i> Back
                </a>

                <button type="submit"
                        wire:loading.attr="disabled"
                        wire:target="save"
                        class="px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold rounded-lg hover:from-blue-700 hover:to-blue-800 transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5 disabled:opacity-75 disabled:cursor-not-allowed disabled:transform-none">
                    <span wire:loading.remove wire:target="save">
                        <i class="fas fa-save mr-2"></i> Save Category
                    </span>
                    <span wire:loading wire:target="save">
                        <i class="fas fa-spinner fa-spin mr-2"></i> Saving...
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>


