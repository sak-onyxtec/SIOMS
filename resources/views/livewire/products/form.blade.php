<div class="card p-4 rounded-3 shadow-sm">

    <form wire:submit.prevent="save">

        {{-- Image Preview Section --}}
        <div class="d-flex justify-content-center mb-4">

            {{-- If user selects a new image, preview that --}}
            @if ($product_image)
                <img 
                    src="{{ $product_image->temporaryUrl() }}" 
                    class="rounded-circle border shadow"
                    width="200" height="200"
                >
            {{-- Otherwise show old stored image --}}
            @elseif ($oldImage)
                <img 
                    src="{{ $oldImage }}"
                    class="rounded-circle border shadow"
                    width="200" height="200"
                >
            @else
                {{-- Default placeholder --}}
                <img 
                    src="#"
                    alt="No Image"
                    class="rounded-circle border shadow"
                    width="200" height="200"
                >
            @endif

        </div>

        {{-- Image Upload Field --}}
        <div class="mb-3 text-center">
            <label class="form-label fw-semibold">Product Image</label>
            <input type="file" wire:model="product_image"  class="form-control rounded-pill">
            @error('product_image') 
                <small class="text-danger">{{ $message }}</small> 
            @enderror
        </div>

        <hr class="my-4">

        {{-- Name --}}
        <div class="mb-3">
            <label class="fw-semibold">Product Name</label>
            <input type="text" wire:model="name" value="{{ $name }}" class="form-control rounded-pill">
            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        {{-- SKU --}}
        <div class="mb-3">
            <label class="fw-semibold">SKU</label>
            <input type="text" wire:model="sku" value="{{ $sku }}" class="form-control rounded-pill">
            @error('sku') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        {{-- Category --}}
        <div class="mb-3">
            <label class="fw-semibold">Category</label>
            <input type="text" wire:model="category" value="{{ $category }}" class="form-control rounded-pill">
        </div>

        {{-- Quantity + Price --}}
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="fw-semibold">Quantity</label>
                <input type="number" wire:model="quantity"  value="{{ $quantity }}"class="form-control rounded-pill">
                @error('quantity') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="fw-semibold">Price</label>
                <input type="number" wire:model="price"  value="{{ $price }}" class="form-control rounded-pill" step="0.01">
                @error('price') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
        </div>

        {{-- Buttons --}}
        <div class="d-flex justify-content-between mt-4">
            <a wire:navigate href="{{ route('product.index') }}" class="btn btn-secondary rounded-pill px-4">
                Back
            </a>

            <button class="btn btn-success rounded-pill px-4">
                Save Product
            </button>
        </div>

    </form>
</div>
