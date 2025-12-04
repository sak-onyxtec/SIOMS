<?php

namespace App\Livewire\Products;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Services\ProductService;
use App\Models\Product;
use App\Models\ProductImage;
use App\Traits\FileManagerTrait;

class Form extends Component
{
    use WithFileUploads, FileManagerTrait;

    public $product_id, $name, $short_description, $description, $sku, $category_id, $quantity, $price;
    public $product_image, $oldImage; // Legacy single image field
    public $product_images = [];
    public $existing_images = [];
    public $removed_images = [];

    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:25',
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'sku' => 'required|max:25|unique:products,sku,' . $this->product_id,
            'category_id' => 'nullable|exists:categories,id',
            'quantity' => 'required|integer|min:0|max:999999',
            'price' => 'required|numeric|min:0|max:99999999',
            'product_image' => 'nullable|image|max:2048',
            'product_images.*' => 'nullable|image|max:2048',
        ];
    }

    public function mount($id = null)
    {
        if ($id) {
            $product = Product::with('images')->findOrFail($id);

            $this->product_id = $product->id;
            $this->name = $product->name;
            $this->short_description = $product->short_description;
            $this->description = $product->description;
            $this->sku = $product->sku;
            $this->category_id = $product->category_id;
            $this->quantity = $product->quantity;
            $this->price = $product->price;
            $this->oldImage = $product->product_image;
            $this->existing_images = $product->images->map(function ($img) {
                return [
                    'id' => $img->id,
                    'url' => $img->image_url,
                    'sort_order' => $img->sort_order,
                ];
            })->toArray();
        }
    }

    /**
     * Live-validate fields as the user types/changes them.
     */
    public function updated($propertyName): void
    {
        $this->validateOnly($propertyName, $this->rules());
    }

    public function removeNewImage($index)
    {
        unset($this->product_images[$index]);
        $this->product_images = array_values($this->product_images);
    }

    public function removeExistingImage($id)
    {
        // Add to removed images array if not already there
        if (!in_array($id, $this->removed_images)) {
            $this->removed_images[] = $id;
        }
        
        // Remove from existing images array using strict comparison
        $this->existing_images = array_filter($this->existing_images, function ($img) use ($id) {
            return (int)$img['id'] !== (int)$id;
        });
        
        // Re-index the array to maintain proper order
        $this->existing_images = array_values($this->existing_images);
    }

    public function save()
    {
        $validated = $this->validate($this->rules());

        // Upload legacy single image if provided using FileManagerTrait
        $legacyImagePath = null;
        if ($this->product_image) {
            $oldImageBasename = $this->oldImage ? basename($this->oldImage) : null;
            $legacyImagePath = $this->upload('uploads/products/', $this->product_image, $oldImageBasename);
        }

        // Upload new multiple images and get their paths using FileManagerTrait
        $uploadedImages = [];
        foreach ($this->product_images as $image) {
            if ($image) {
                $filename = $this->upload('uploads/products/', $image);
                $uploadedImages[] = $filename;
            }
        }

        // Prepare request data - ensure product_image is included if uploaded
        $requestData = $validated;
        if ($legacyImagePath) {
            $requestData['product_image'] = $legacyImagePath;
        }
        $requestData['uploaded_images'] = $uploadedImages;
        $requestData['existing_images'] = $this->existing_images;
        $requestData['removed_images'] = $this->removed_images;

        $request = request()->merge($requestData);

        // Resolve ProductService when needed
        $productService = app(ProductService::class);

        if ($this->product_id) {
            // Update existing product
            $product = $productService->updateProduct($request, $this->product_id);
        } else {
            // Add new product
            $product = $productService->addProduct($request);
        }

        return redirect()->route('product.index')->with('success', 'Product saved!');
    }

    public function render()
    {
        return view('livewire.products.form');
    }
}
