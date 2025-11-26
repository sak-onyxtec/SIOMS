<?php

namespace App\Livewire\Products;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Services\ProductService;
use App\Models\Product;
use App\Traits\FileManagerTrait;

class Form extends Component
{
    use WithFileUploads, FileManagerTrait;

    public $product_id, $name, $sku, $category, $quantity, $price, $product_image, $oldImage;

    public function mount($id = null)
    {
        if ($id) {
            $product = Product::findOrFail($id);

            $this->product_id = $product->id;
            $this->name = $product->name;
            $this->sku = $product->sku;
            $this->category = $product->category;
            $this->quantity = $product->quantity;
            $this->price = $product->price;
            $this->oldImage = $product->product_image;
        }
    }

    public function save()
    {
        $validated = $this->validate([
            'name' => 'required',
            'sku' => 'required|unique:products,sku,' . $this->product_id,
            'category' => 'nullable',
            'quantity' => 'required|numeric',
            'price' => 'required|numeric',
            'product_image' => 'nullable|image',
        ]);

        $request = request()->merge($validated);

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
