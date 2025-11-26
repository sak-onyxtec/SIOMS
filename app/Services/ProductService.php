<?php

namespace App\Services;

use App\Helpers\Pagination;
use App\Models\Product;
use App\Traits\FileManagerTrait;
use Illuminate\Http\Request;
use App\Events\ProductChanged;

class ProductService
{
    use FileManagerTrait;

    public function addProduct(Request $request)
    {
        $product = Product::create($request->toArray());

        if ($request->hasFile('product_image')) {
            $file = $this->upload('uploads/products/', $request->product_image);
            $product->product_image = $file;
            $product->save();
        }

        event(new ProductChanged($product->id, 'created', null, $product->toArray()));

        return $product;
    }

    public function updateProduct(Request $request, $id)
    {
        $product = Product::find($id);
        if (!$product) return null;

        $before = $product->toArray();

        if ($request->hasFile('product_image')) {
            $file = $this->upload('uploads/products/', $request->product_image, basename($product->product_image));
            $product->product_image = $file;
        }

        $product->fill($request->toArray());
        $product->save();

        event(new ProductChanged($product->id, 'updated', $before, $product->toArray()));

        return $product;
    }
    public function getProducts(Request $request)
    {
        $products = Product::when($request->filled('search'), function ($query) use ($request) {
            $query->where(function ($sq) use ($request) {
                $search = '%' . $request->search . '%';
                $sq->whereAny([
                    'name',
                    'category'
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
