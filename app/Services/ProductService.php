<?php

namespace App\Services;

use App\Helpers\Pagination;
use App\Models\Product;
use App\Models\ProductImage;
use App\Traits\FileManagerTrait;
use Illuminate\Http\Request;
use App\Events\ProductChanged;

class ProductService
{
    use FileManagerTrait;

    public function addProduct(Request $request)
    {
        $data = $request->only([
            'name',
            'short_description',
            'description',
            'slug',
            'sku',
            'category_id',
            'quantity',
            'price',
        ]);
        
        // Generate slug if not provided
        if (empty($data['slug']) && !empty($data['name'])) {
            $data['slug'] = \Illuminate\Support\Str::slug($data['name']);
            // Ensure uniqueness
            $baseSlug = $data['slug'];
            $counter = 1;
            while (Product::where('slug', $data['slug'])->exists()) {
                $data['slug'] = $baseSlug . '-' . $counter;
                $counter++;
            }
        }
        
        // Handle legacy single image - check if it's already uploaded (string) or needs upload (file)
        if ($request->has('product_image')) {
            if ($request->hasFile('product_image')) {
                // File needs to be uploaded
                $data['product_image'] = $this->upload('uploads/products/', $request->product_image);
            } elseif (is_string($request->product_image)) {
                // Already uploaded, just use the path
                $data['product_image'] = $request->product_image;
            }
        }
        
        $product = Product::create($data);

        // Handle multiple images
        $this->saveProductImages($product, $request);

        event(new ProductChanged($product->id, 'created', null, $product->toArray()));

        return $product;
    }

    public function updateProduct(Request $request, $id)
    {
        $product = Product::with('images')->find($id);
        if (!$product) return null;

        $before = $product->toArray();

        $data = $request->only([
            'name',
            'short_description',
            'description',
            'slug',
            'sku',
            'category_id',
            'quantity',
            'price',
        ]);
        
        // Handle legacy single image - check if it's already uploaded (string) or needs upload (file)
        if ($request->has('product_image')) {
            if ($request->hasFile('product_image')) {
                // File needs to be uploaded
                $oldImagePath = $product->product_image ? basename($product->product_image) : null;
                $data['product_image'] = $this->upload('uploads/products/', $request->product_image, $oldImagePath);
            } elseif (is_string($request->product_image)) {
                // Already uploaded, just use the path
                $data['product_image'] = $request->product_image;
            }
        }
        
        // Generate slug if name changed and slug not explicitly provided
        $originalName = $product->name;
        if (!empty($data['name']) && $data['name'] !== $originalName && empty($data['slug'])) {
            $data['slug'] = \Illuminate\Support\Str::slug($data['name']);
            // Ensure uniqueness
            $baseSlug = $data['slug'];
            $counter = 1;
            while (Product::where('slug', $data['slug'])->where('id', '!=', $product->id)->exists()) {
                $data['slug'] = $baseSlug . '-' . $counter;
                $counter++;
            }
        }
        
        $product->fill($data);
        $product->save();

        // Handle multiple images
        $this->saveProductImages($product, $request);

        event(new ProductChanged($product->id, 'updated', $before, $product->toArray()));

        return $product;
    }

    protected function saveProductImages(Product $product, Request $request)
    {
        // Remove deleted images
        if ($request->has('removed_images') && is_array($request->removed_images)) {
            ProductImage::whereIn('id', $request->removed_images)->delete();
        }

        // Update existing images (sort order)
        if ($request->has('existing_images') && is_array($request->existing_images)) {
            foreach ($request->existing_images as $imgData) {
                if (isset($imgData['id'])) {
                    ProductImage::where('id', $imgData['id'])->update([
                        'sort_order' => $imgData['sort_order'] ?? 0,
                    ]);
                }
            }
        }

        // Save new uploaded images (already uploaded in Form component, just use the paths)
        if ($request->has('uploaded_images') && is_array($request->uploaded_images)) {
            $sortOrder = ProductImage::where('product_id', $product->id)->max('sort_order') ?? 0;
            
            foreach ($request->uploaded_images as $filename) {
                // $filename is already the uploaded path, not a file object
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $filename,
                    'sort_order' => ++$sortOrder,
                    'is_primary' => false,
                ]);
            }
        }
    }
    public function getProducts(Request $request)
    {
        $products = Product::when($request->filled('search'), function ($query) use ($request) {
            $query->where(function ($sq) use ($request) {
                $search = '%' . $request->search . '%';
                $sq->whereAny([
                    'name',
                ], 'LIKE', $search);
            });
        })->latest();

        $response = Pagination::paginate($request, $products, 'products');

        return $response;
    }

    public function deleteProduct(Request $request, $id)
    {
        $product = Product::find($id);
        if (!$product) return null;

        $before = $product->toArray();
        $product->delete();

        event(new ProductChanged($id, 'deleted', $before, null));

        return true;
    }
}
