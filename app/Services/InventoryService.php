<?php

namespace App\Services;

use App\Models\Product;
use App\Models\InventoryTransaction;
use Illuminate\Support\Facades\Auth;

class InventoryService
{
    /**
     * Handle inventory transaction
     */
    public function process($productId, $type, $quantity, $notes = null)
    {
        $product = Product::findOrFail($productId);

        // Prevent negative stock
        if ($type === 'stock_out' && $product->quantity < $quantity) {
            throw new \Exception('Not enough stock available.');
        }

        // Adjust stock
        if ($type === 'stock_in') {
            $product->increment('quantity', $quantity);
        } elseif ($type === 'stock_out') {
            $product->decrement('quantity', $quantity);
        } elseif ($type === 'adjustment') {
            $product->quantity = $quantity;
            $product->save();
        }

        $inventory = InventoryTransaction::create([
            'type'       => $type,
            'quantity'   => $quantity,
            'notes'      => $notes,
        ]);
        $inventory->product_id = $productId;
        $inventory->user_id = Auth::id();
        $inventory->save();
    }
}
