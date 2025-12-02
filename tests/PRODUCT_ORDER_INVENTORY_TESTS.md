### Product, Order & Inventory Test Plan (80%+ Coverage)

This document describes how to cover the **product**, **order**, and **inventory** flows with automated tests and how to run coverage reports to reach **≥ 80%** project coverage.

---

## 1. Running the Test Suite with Coverage

From the project root (`/opt/lampp/htdocs/SIOMS`):

- **Console coverage summary (using Laravel test runner):**

```bash
php artisan test --coverage
```

- **HTML coverage report (opens in `coverage/index.html`):**

```bash
./vendor/bin/phpunit --coverage-html coverage
```

- **Enforce minimum 80% coverage:**

```bash
php artisan test --coverage --min=80
```

or:

```bash
./vendor/bin/phpunit --coverage-html coverage --min=80
```

> Make sure Xdebug or PCOV is enabled in your PHP environment so code coverage works.

---

## 2. Product Flow – Suggested / Existing Tests

### 2.1 API CRUD Tests (already implemented)

File: `tests/Feature/API/ProductCrudTest.php`

This file already covers most of the **product flow** through API endpoints:

- **Create product**
  - `test_can_create_product`
  - Validates payload and asserts DB record.
- **Validation & auth**
  - `test_cannot_create_product_with_invalid_data`
  - `test_cannot_create_product_with_duplicate_sku`
  - `test_cannot_create_product_without_authentication` (checks `auth:sanctum` middleware).
- **Listing & search**
  - `test_can_get_all_products`
  - `test_can_search_products`
- **Read single product**
  - `test_can_get_single_product`
  - `test_cannot_get_nonexistent_product`
- **Update product**
  - `test_can_update_product`
  - `test_cannot_update_product_with_invalid_data`
  - `test_cannot_update_nonexistent_product`
- **Delete product**
  - `test_can_delete_product`
  - `test_cannot_delete_nonexistent_product`

These tests give strong **Feature-level** coverage of:

- `Product` model basic fields
- Product API controller/service layer
- Validation rules around SKU, price, quantity, and required fields

### 2.2 Optional: Model-Level Behaviour (slug, relationships)

If you want deeper coverage of `App\Models\Product`, you can add a **Unit test** file like:

File: `tests/Unit/ProductTest.php`

```php
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
```

This unit test increases coverage of the **slug generation** logic and the model boot callbacks.

---

## 3. Order Flow – Existing Unit Tests

File: `tests/Unit/OrderServiceTest.php`

This file thoroughly covers the **order flow** implemented in `App\Services\OrderService`:

- **Add order with items**
  - `test_can_add_order_with_items`
  - Creates a user, category, products.
  - Mocks `InventoryService::process` to assert `stock_out` calls.
  - Asserts:
    - `orders` row (status, total, user_id).
    - Generated `uid` prefix `ORD-`.
    - `order_items` rows (quantities, prices).
    - `order_trails` initial `pending` entry.

- **Add order without items**
  - `test_can_add_order_without_items`
  - Ensures order is created with total=0 and no items.

- **Skip items with insufficient stock**
  - `test_add_order_skips_items_with_insufficient_stock`
  - Ensures only items with enough stock are turned into `order_items`.

- **Update order**
  - `test_can_update_order`
  - Removes old items, inserts new items, and asserts DB state.
  - Verifies `InventoryService::process` for updated items.
  - `test_update_order_returns_null_for_nonexistent_order`

- **Change order status**
  - `test_can_change_order_status`
  - Updates status, verifies DB row and `order_trails` entry.
  - `test_change_order_status_to_cancelled_restores_inventory`
    - When status → `cancelled`, asserts `InventoryService::process` called with `stock_in`.
  - `test_change_order_status_returns_null_for_nonexistent_order`

- **Delete order**
  - `test_can_delete_order`
  - `test_delete_order_returns_null_for_nonexistent_order`

- **Get orders (listing, filters, pagination)**
  - `test_get_orders_with_search`
  - `test_get_orders_with_status_filter`
  - `test_get_orders_with_pagination`
    - Asserts `per_page`, total count, and subset of orders returned.

These tests together give **high coverage** of:

- Order creation/update/delete lifecycle
- Status transitions and their side effects
- Integration with inventory through a mocked `InventoryService`
- Query filters and pagination in `OrderService::getOrders`

---

## 4. Inventory Flow – Suggested Tests

### 4.1 Unit Tests for `InventoryService`

File suggestion: `tests/Unit/InventoryServiceTest.php`

```php
<?php

namespace Tests\Unit;

use App\Models\InventoryTransaction;
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
```

This unit test file gives direct coverage of:

- Guard against negative inventory
- Stock in/out quantity adjustments
- `InventoryTransaction` creation

### 4.2 Livewire Inventory Component Flow

If you want to cover the **admin inventory screen** (`App\Livewire\Inventory\Index`), you can add a Feature test:

File suggestion: `tests/Feature/InventoryComponentTest.php`

```php
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
            ->call('saveTransaction')
            ->assertSessionHas('success');

        $product->refresh();
        $this->assertSame(8, $product->quantity);
    }
}
```

This connects the UI flow to the underlying `InventoryService::process` logic and increases **Feature coverage**.

---

## 5. Hitting 80%+ Coverage

To reach and maintain **≥ 80% coverage**:

1. Keep / extend:
   - `tests/Feature/API/ProductCrudTest.php`
   - `tests/Unit/OrderServiceTest.php`
2. Add the **suggested unit tests** for:
   - `Product` model (slug, etc.).
   - `InventoryService`.
3. Optionally add Feature tests for:
   - `App\Livewire\Inventory\Index` (admin inventory UI).
4. Run:

```bash
php artisan test --coverage --min=80
```

Adjust or add tests if coverage for `app/` classes (shown in the coverage report) is still below the desired threshold.


