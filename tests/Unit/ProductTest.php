<?php

namespace Tests\Unit;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_slug_is_generated_when_creating_product_without_slug(): void
    {
        $product = Product::create([
            'name' => 'Test Product',
            'short_description' => 'Short',
            'description' => 'Long description',
            'sku' => 'SKU-001',
            'quantity' => 5,
            'price' => 100,
        ]);

        $this->assertNotNull($product->slug);
        $this->assertSame('test-product', $product->slug);
    }

    public function test_slug_is_unique_when_creating_products_with_same_name(): void
    {
        $first = Product::create([
            'name' => 'Duplicate',
            'sku' => 'SKU-100',
            'quantity' => 1,
            'price' => 10,
        ]);

        $second = Product::create([
            'name' => 'Duplicate',
            'sku' => 'SKU-101',
            'quantity' => 1,
            'price' => 10,
        ]);

        $this->assertSame('duplicate', $first->slug);
        $this->assertNotSame($first->slug, $second->slug);
        $this->assertStringStartsWith('duplicate-', $second->slug);
    }
}


