<?php

namespace Tests\Feature;

use App\Livewire\Inventory\Index;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class InventoryComponentTest extends TestCase
{
    use RefreshDatabase;

    public function test_inventory_component_can_create_stock_in_transaction(): void
    {
        $product = Product::create([
            'name' => 'Inventory Component Product',
            'sku' => 'INV-COMP-1',
            'quantity' => 5,
            'price' => 25,
        ]);

        Livewire::test(Index::class)
            ->set('product_id', $product->id)
            ->set('type', 'stock_in')
            ->set('quantity', 3)
            ->set('notes', 'Component test')
            ->call('saveTransaction');

        $product->refresh();
        $this->assertSame(8, $product->quantity);
    }
}


