<div class="max-w-full mx-auto p-6">
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
            <h2 class="text-2xl font-bold text-white">
                {{ $product_id ? 'Edit Product' : 'Create New Product' }}
            </h2>
        </div>

        <form wire:submit.prevent="save" class="p-6 space-y-6">
            {{-- Legacy Single Product Image --}}
            <div class="border-b border-gray-200 pb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-3">
                    Primary Product Image
                </label>
                
                <div class="flex flex-col items-center mb-4">
                    @if ($product_image)
                        <img src="{{ $product_image->temporaryUrl() }}" 
                            class="rounded-lg border-2 border-gray-200 shadow-md"
                            width="200" height="200"
                            style="object-fit: cover;">
                    @elseif ($oldImage)
                        <img src="{{ $oldImage }}"
                            class="rounded-lg border-2 border-gray-200 shadow-md"
                            width="200" height="200"
                            style="object-fit: cover;">
                    @else
                        <div class="w-48 h-48 bg-gray-100 rounded-lg border-2 border-dashed border-gray-300 flex items-center justify-center">
                            <i class="fas fa-image text-gray-400 text-4xl"></i>
                        </div>
                    @endif
                </div>

                <div class="text-center">
                    <input type="file" 
                        wire:model="product_image" 
                        accept="image/*"
                        class="hidden" 
                        id="single-image-upload">
                    <label for="single-image-upload" 
                        class="inline-block px-4 py-2 bg-gray-100 text-gray-700 rounded-lg cursor-pointer hover:bg-gray-200 transition-colors duration-200">
                        <i class="fas fa-upload mr-2"></i> Upload Primary Image
                    </label>
                </div>
                @error('product_image') 
                    <p class="mt-2 text-sm text-red-600 text-center">{{ $message }}</p> 
                @enderror
            </div>

            {{-- Product Name --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Product Name <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                    wire:model.live.debounce.300ms="name" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200 @error('name') border-red-500 @enderror"
                    placeholder="Enter product name" maxlength="25">
                @error('name') 
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p> 
                @enderror
            </div>

            {{-- Short Description --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Short Description
                    <span class="text-xs text-gray 500 ml-1">(Shown on product cards and listings)</span>
                </label>
                <textarea
                    wire:model.live.debounce.300ms="short_description"
                    rows="3"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200 @error('short_description') border-red-500 @enderror"
                    placeholder="Write a brief summary of the product (1–2 sentences)..."></textarea>
                @error('short_description') 
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p> 
                @enderror
            </div>

            {{-- SKU --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    SKU <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                    wire:model.live.debounce.300ms="sku" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200 @error('sku') border-red-500 @enderror"
                    placeholder="Enter SKU" maxlength="25">
                @error('sku') 
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p> 
                @enderror
            </div>

            {{-- Category --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Category
                </label>
                <select wire:model.live="category_id" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200 @error('category_id') border-red-500 @enderror">
                    <option value="">Select Category</option>
                    @foreach (\App\Models\Category::query()->orderBy('name')->get() as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
                @error('category_id') 
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p> 
                @enderror
            </div>

            {{-- Quantity and Price --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Quantity <span class="text-red-500">*</span>
                    </label>
                    <input type="number" 
                        wire:model.live.debounce.300ms="quantity" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200 @error('quantity') border-red-500 @enderror"
                        placeholder="0"
                        min="0"
                        max="999999"
                        maxlength="6">
                    @error('quantity') 
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p> 
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Price <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500 font-semibold">$</span>
                        <input type="number" 
                            wire:model.live.debounce.300ms="price" 
                            step="0.01"
                            class="w-full pl-8 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200 @error('price') border-red-500 @enderror"
                            placeholder="0.00"
                            min="0"
                            max="99999999"
                            maxlength="8">
                    </div>
                    @error('price') 
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p> 
                    @enderror
                </div>
            </div>

            {{-- Detailed Description --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Detail Description
                    <span class="text-xs text-gray 500 ml-1">(Shown on product cards and listings)</span>
                </label>
                <textarea
                    wire:model.live.debounce.300ms="description"
                    rows="3"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200 @error('description') border-red-500 @enderror"
                    placeholder="Write a brief summary of the product (1–2 sentences)..."></textarea>
                @error('description') 
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p> 
                @enderror
            </div>

            {{-- Multiple Product Images Section (at the end) --}}
            <div class="pt-4">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Additional Product Images
                    <span class="text-gray-500 font-normal text-xs ml-2">(Optional - You can upload multiple images)</span>
                </label>

                {{-- Existing Images Gallery --}}
                @if(count($existing_images) > 0)
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-3">
                        @foreach($existing_images as $index => $img)
                            <div wire:key="existing-image-{{ $img['id'] }}" class="relative group border-2 border-gray-200 rounded-lg overflow-hidden">
                                <img src="{{ $img['url'] }}" alt="Product Image" class="w-full h-24 object-cover">
                                <div class="absolute inset-0 bg-opacity-0 group-hover:bg-opacity-50 transition-all duration-200 flex items-center justify-center">
                                    <button type="button" 
                                        wire:click="removeExistingImage({{ $img['id'] }})"
                                        class="opacity-1 group-hover:opacity-100 transform translate-y-2 group-hover:translate-y-0 transition-all duration-200 bg-red-600 text-white px-3 py-2 rounded text-xs font-semibold hover:bg-red-700">
                                        <i class="fas fa-trash mr-1"></i> Remove
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                {{-- New Images Preview --}}
                @if(count($product_images) > 0)
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-3">
                        @foreach($product_images as $index => $image)
                            <div class="relative border-2 border-dashed border-gray-300 rounded-lg overflow-hidden group">
                                <img src="{{ $image->temporaryUrl() }}" alt="New Image" class="w-full h-24 object-cover">
                                <button type="button" 
                                    wire:click="removeNewImage({{ $index }})"
                                    class="absolute top-1 right-1 opacity-1 group-hover:opacity-100 transition-opacity duration-200 bg-red-600 text-white p-1.5 rounded-full hover:bg-red-700">
                                    <i class="fas fa-times text-xs"></i>
                                </button>
                            </div>
                        @endforeach
                    </div>
                @endif

                {{-- Image Upload Input --}}
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-blue-400 transition-colors duration-200">
                    <input type="file" 
                        wire:model="product_images" 
                        multiple
                        accept="image/*"
                        class="hidden" 
                        id="image-upload">
                    <label for="image-upload" class="cursor-pointer">
                        <div class="flex flex-col items-center">
                            <svg class="w-8 h-8 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <p class="text-xs font-semibold text-gray-700 mb-0.5">Click to upload additional images</p>
                            <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB each</p>
                        </div>
                    </label>
                </div>
                @error('product_images.*') 
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p> 
                @enderror
            </div>

            {{-- Action Buttons --}}
            <div class="flex justify-between items-center pt-6 border-t border-gray-200">
                <a wire:navigate 
                    href="{{ route('product.index') }}" 
                    class="px-6 py-3 no-underline border border-gray-300 rounded-lg text-gray-700 font-semibold hover:bg-gray-50 transition-colors duration-200">
                    <i class="fas fa-arrow-left mr-2"></i> Back
                </a>

                <button type="submit"
                        wire:loading.attr="disabled"
                        wire:target="save"
                        class="px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold rounded-lg hover:from-blue-700 hover:to-blue-800 transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5 disabled:opacity-75 disabled:cursor-not-allowed disabled:transform-none">
                    <span wire:loading.remove wire:target="save">
                        <i class="fas fa-save mr-2"></i> Save Product
                    </span>
                    <span wire:loading wire:target="save">
                        <i class="fas fa-spinner fa-spin mr-2"></i> Saving...
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    <script>
        document.addEventListener('livewire:load', () => {
            const textarea = document.querySelector('#description-editor');
            if (!textarea) return;

            ClassicEditor
                .create(textarea)
                .then(editor => {
                    editor.model.document.on('change:data', () => {
                        @this.set('description', editor.getData());
                    });
                })
                .catch(error => {
                    console.error(error);
                });
        });
    </script>
@endpush
