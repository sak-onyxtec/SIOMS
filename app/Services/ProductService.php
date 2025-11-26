<?php

namespace App\Services;

use App\Helpers\Pagination;
use App\Models\Product;
use App\Models\ProductChangeLog;
use App\Traits\FileManagerTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductService
{
    use FileManagerTrait;

    public function addProduct(Request $request)
    {
        $product = Product::create($request->toArray());
        if ($request->hasFile('product_image')) {
            $file = $this->upload('uploads/products/', $request->product_image);
            $product->product_image = $file;
        }
        $this->logChange($product->id, 'created', null, $product->toArray());
        $product->save();

        return $product;
    }

    public function updateProduct(Request $request, $id)
    {
        $product = Product::find($id);
        if (!$product) {
            return null;
        }

        $before = $product->toArray();

        if ($request->hasFile('product_image')) {
            $file = $this->upload('uploads/products/', $request->product_image, basename($product->product_image));
            $product->product_image = $file;
        }

        $product->fill($request->toArray());
        $product->save();

        $this->logChange($product->id, 'updated', $before, $product->toArray());

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
        if (!$product) {
            return null;
        }

        $before = $product->toArray();

        $product->delete();

        $this->logChange($id, 'deleted', $before, null);

        return true;
    }

    private function logChange($productId, $action, $before = null, $after = null)
    {
        ProductChangeLog::create([
            'product_id' => $productId,
            'action_by' => Auth::id(),
            'action' => $action,
            'before' => $before ? json_encode($before) : null,
            'after' => $after ? json_encode($after) : null,
        ]);
    }
}
