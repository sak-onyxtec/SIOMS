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

    public $product_id, $name, $sku, $category_id, $quantity, $price;
    public $product_image, $oldImage; // Legacy single image field
    public $product_images = [];
    public $existing_images = [];
    public $removed_images = [];

    public function mount($id = null)
    {
        if ($id) {
            $product = Product::with('images')->findOrFail($id);

            $this->product_id = $product->id;
            $this->name = $product->name;
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

    public function removeNewImage($index)
    {
        unset($this->product_images[$index]);
        $this->product_images = array_values($this->product_images);
    }

    public function removeExistingImage($id)
    {
        $this->removed_images[] = $id;
        $this->existing_images = array_filter($this->existing_images, function ($img) use ($id) {
            return $img['id'] != $id;
        });
        $this->existing_images = array_values($this->existing_images);
    }

    public function save()
    {
        $validated = $this->validate([
            'name' => 'required',
            'sku' => 'required|unique:products,sku,' . $this->product_id,
            'category_id' => 'nullable|exists:categories,id',
            'quantity' => 'required|numeric',
            'price' => 'required|numeric',
            'product_image' => 'nullable|image|max:2048', // Legacy single image
            'product_images.*' => 'nullable|image|max:2048',
        ]);

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
