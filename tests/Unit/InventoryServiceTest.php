<?php

namespace Tests\Unit;

use App\Models\Product;
use App\Services\InventoryService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InventoryServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_stock_in_increases_quantity_and_creates_transaction(): void
    {
        $product = Product::create([
            'name' => 'Stock In Product',
            'sku' => 'INV-001',
            'quantity' => 5,
            'price' => 50,
        ]);

        $service = new InventoryService();
        $service->process($product->id, 'stock_in', 3, 'Restock');

        $product->refresh();
        $this->assertSame(8, $product->quantity);

        $this->assertDatabaseHas('inventory_transactions', [
            'product_id' => $product->id,
            'type'       => 'stock_in',
            'quantity'   => 3,
            'notes'      => 'Restock',
        ]);
    }

    public function test_stock_out_decreases_quantity(): void
    {
        $product = Product::create([
            'name' => 'Stock Out Product',
            'sku' => 'INV-002',
            'quantity' => 10,
            'price' => 100,
        ]);

        $service = new InventoryService();
        $service->process($product->id, 'stock_out', 4, 'Order usage');

        $product->refresh();
        $this->assertSame(6, $product->quantity);
    }

    public function test_stock_out_throws_exception_when_not_enough_stock(): void
    {
        $product = Product::create([
            'name' => 'Limited Stock',
            'sku' => 'INV-003',
            'quantity' => 1,
            'price' => 20,
        ]);

        $service = new InventoryService();

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Not enough stock available.');

        $service->process($product->id, 'stock_out', 5, 'Overuse');

        $this->assertDatabaseCount('inventory_transactions', 0);
    }
}


