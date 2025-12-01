<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        return view('product.index');
    }

    public function listing()
    {
        return view('product.listing');
    }

    public function detail($id)
    {
        return view('product.detail')->with('id', $id);
    }


    public function create()
    {
        return view('product.create');
    }

    public function cart()
    {
        return view('cart.index');
    }

    public function inventory()
    {
        return view('inventory.index');
    }

    public function edit($id)
    {
        return view('product.edit')->with(['id' => $id]);
    }
    public function view($id)
    {
        return view('product.view')->with(['id' => $id]);
    }

    // public function update(Request $request, $id)
    // {
    //     $product = Product::findOrFail($id);

    //     $validated = $request->validate([
    //         'name' => 'required|string|max:255',
    //         'sku' => 'required|string|max:255|unique:products,sku,' . $product->id,
    //         'category' => 'required|string|max:255',
    //         'quantity' => 'required|integer',
    //         'price' => 'required|numeric',
    //     ]);

    //     $product->update($validated);

    //     return redirect()->route('product.index')->with('success', 'Product updated successfully!');
    // }

    // public function destroy($id)
    // {
    //     $product = Product::findOrFail($id);
    //     $product->delete();

    //     return redirect()->route('product.index')->with('success', 'Product deleted successfully!');
    // }
}
