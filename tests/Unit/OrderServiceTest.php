<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderTrail;
use App\Models\Product;
use App\Models\User;
use App\Services\InventoryService;
use App\Services\OrderService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mockery;
use Tests\TestCase;

class OrderServiceTest extends TestCase
{
    use RefreshDatabase;

    protected OrderService $orderService;
    protected $mockInventoryService;
    protected User $user;
    protected Category $category;
    protected Product $product1;
    protected Product $product2;

    protected function setUp(): void
    {
        parent::setUp();

        // Create category
        $this->category = Category::create([
            'name' => 'Test Category',
            'slug' => 'test-category-' . uniqid(), // Use unique slug to avoid conflicts
            'is_active' => true,
        ]);

        // Create user
        $this->user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        Auth::login($this->user);

        // Create products
        $this->product1 = Product::create([
            'name' => 'Product 1',
            'sku' => 'SKU-001',
            'category_id' => $this->category->id,
            'price' => 10.00,
            'quantity' => 100,
        ]);

        $this->product2 = Product::create([
            'name' => 'Product 2',
            'sku' => 'SKU-002',
            'category_id' => $this->category->id,
            'price' => 20.00,
            'quantity' => 50,
        ]);

        // Mock InventoryService
        $this->mockInventoryService = Mockery::mock(InventoryService::class);
        $this->orderService = new OrderService($this->mockInventoryService);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_can_add_order_with_items(): void
    {
        // Mock inventory service to expect process calls
        $this->mockInventoryService
            ->shouldReceive('process')
            ->with($this->product1->id, 'stock_out', 5, Mockery::pattern('/Order #ORD-/'))
            ->once();

        $this->mockInventoryService
            ->shouldReceive('process')
            ->with($this->product2->id, 'stock_out', 3, Mockery::pattern('/Order #ORD-/'))
            ->once();

        $request = new Request([
            'total' => 110.00, // (10 * 5) + (20 * 3)
            'items' => [
                [
                    'product_id' => $this->product1->id,
                    'quantity' => 5,
                ],
                [
                    'product_id' => $this->product2->id,
                    'quantity' => 3,
                ],
            ],
        ]);

        $order = $this->orderService->addOrder($request);

        // Assert order was created
        $this->assertInstanceOf(Order::class, $order);
        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'user_id' => $this->user->id,
            'status' => 'pending',
            'total' => 110.00,
        ]);

        // Assert order has UID
        $this->assertNotNull($order->uid);
        $this->assertStringStartsWith('ORD-', $order->uid);

        // Assert order items were created
        $this->assertCount(2, $order->items);
        $this->assertDatabaseHas('order_items', [
            'order_id' => $order->id,
            'product_id' => $this->product1->id,
            'quantity' => 5,
            'unit_price' => 10.00,
            'total_price' => 50.00,
        ]);
        $this->assertDatabaseHas('order_items', [
            'order_id' => $order->id,
            'product_id' => $this->product2->id,
            'quantity' => 3,
            'unit_price' => 20.00,
            'total_price' => 60.00,
        ]);

        // Assert order trail was created
        $this->assertDatabaseHas('order_trails', [
            'order_id' => $order->id,
            'user_id' => $this->user->id,
            'status' => 'pending',
        ]);
    }

    public function test_can_add_order_without_items(): void
    {
        $request = new Request([
            'total' => 0,
            'items' => [],
        ]);

        $order = $this->orderService->addOrder($request);

        $this->assertInstanceOf(Order::class, $order);
        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'user_id' => $this->user->id,
            'status' => 'pending',
            'total' => 0,
        ]);

        // No items should be created
        $this->assertCount(0, $order->items);
    }

    public function test_add_order_skips_items_with_insufficient_stock(): void
    {
        // Create product with low stock
        $lowStockProduct = Product::create([
            'name' => 'Low Stock Product',
            'sku' => 'SKU-LOW',
            'category_id' => $this->category->id,
            'price' => 15.00,
            'quantity' => 2, // Only 2 in stock
        ]);

        // Mock inventory service - should not be called for low stock product
        $this->mockInventoryService
            ->shouldReceive('process')
            ->with($this->product1->id, 'stock_out', 5, Mockery::pattern('/Order #ORD-/'))
            ->once();

        $request = new Request([
            'total' => 50.00,
            'items' => [
                [
                    'product_id' => $this->product1->id,
                    'quantity' => 5, // Valid
                ],
                [
                    'product_id' => $lowStockProduct->id,
                    'quantity' => 10, // Invalid: more than available stock
                ],
            ],
        ]);

        $order = $this->orderService->addOrder($request);

        // Only one item should be created
        $this->assertCount(1, $order->items);
        $this->assertDatabaseHas('order_items', [
            'order_id' => $order->id,
            'product_id' => $this->product1->id,
        ]);
        $this->assertDatabaseMissing('order_items', [
            'order_id' => $order->id,
            'product_id' => $lowStockProduct->id,
        ]);
    }

    public function test_can_update_order(): void
    {
        // Create initial order
        $order = Order::create([
            'user_id' => $this->user->id,
            'status' => 'pending',
            'total' => 50.00,
            'uid' => 'ORD-20250101-1',
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $this->product1->id,
            'quantity' => 5,
            'unit_price' => 10.00,
            'total_price' => 50.00,
        ]);

        // Mock inventory service - use any() for the last parameter since UID might vary
        $this->mockInventoryService
            ->shouldReceive('process')
            ->with($this->product2->id, 'stock_out', 3, Mockery::any())
            ->once();

        $request = new Request([
            'items' => [
                [
                    'product_id' => $this->product2->id,
                    'quantity' => 3,
                ],
            ],
        ]);

        $updatedOrder = $this->orderService->updateOrder($request, $order->id);

        $this->assertInstanceOf(Order::class, $updatedOrder);
        
        // Old items should be deleted
        $this->assertDatabaseMissing('order_items', [
            'order_id' => $order->id,
            'product_id' => $this->product1->id,
        ]);

        // New items should be created
        $this->assertDatabaseHas('order_items', [
            'order_id' => $order->id,
            'product_id' => $this->product2->id,
            'quantity' => 3,
        ]);
    }

    public function test_update_order_returns_null_for_nonexistent_order(): void
    {
        $request = new Request([
            'items' => [],
        ]);

        $result = $this->orderService->updateOrder($request, 99999);

        $this->assertNull($result);
    }

    public function test_can_change_order_status(): void
    {
        $order = Order::create([
            'user_id' => $this->user->id,
            'status' => 'pending',
            'total' => 50.00,
            'uid' => 'ORD-20250101-1',
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $this->product1->id,
            'quantity' => 5,
            'unit_price' => 10.00,
            'total_price' => 50.00,
        ]);

        $request = new Request([
            'status' => 'confirmed',
        ]);

        $updatedOrder = $this->orderService->changeOrderStatus($request, $order->id);

        $this->assertInstanceOf(Order::class, $updatedOrder);
        $this->assertEquals('confirmed', $updatedOrder->status);
        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'confirmed',
        ]);

        // Order trail should be created
        $this->assertDatabaseHas('order_trails', [
            'order_id' => $order->id,
            'user_id' => $this->user->id,
            'status' => 'confirmed',
        ]);
    }

    public function test_change_order_status_to_cancelled_restores_inventory(): void
    {
        $order = Order::create([
            'user_id' => $this->user->id,
            'status' => 'pending',
            'total' => 50.00,
            'uid' => 'ORD-20250101-1',
        ]);

        $orderItem = OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $this->product1->id,
            'quantity' => 5,
            'unit_price' => 10.00,
            'total_price' => 50.00,
        ]);

        // Ensure the order item is saved and relationship is loaded
        $order->refresh();
        $this->assertCount(1, $order->items, 'Order should have 1 item');

        // Mock inventory service to restore stock
        $this->mockInventoryService
            ->shouldReceive('process')
            ->with($this->product1->id, 'stock_in', 5, Mockery::any())
            ->once();

        $request = new Request([
            'status' => 'cancelled',
        ]);

        $updatedOrder = $this->orderService->changeOrderStatus($request, $order->id);

        $this->assertEquals('cancelled', $updatedOrder->status);
    }

    public function test_change_order_status_returns_null_for_nonexistent_order(): void
    {
        $request = new Request([
            'status' => 'confirmed',
        ]);

        $result = $this->orderService->changeOrderStatus($request, 99999);

        $this->assertNull($result);
    }

    public function test_can_delete_order(): void
    {
        $order = Order::create([
            'user_id' => $this->user->id,
            'status' => 'pending',
            'total' => 50.00,
            'uid' => 'ORD-20250101-1',
        ]);

        $result = $this->orderService->deleteOrder($order->id);

        $this->assertTrue($result);
        $this->assertDatabaseMissing('orders', [
            'id' => $order->id,
        ]);
    }

    public function test_delete_order_returns_null_for_nonexistent_order(): void
    {
        $result = $this->orderService->deleteOrder(99999);

        $this->assertNull($result);
    }

    public function test_get_orders_with_search(): void
    {
        $order1 = Order::create([
            'user_id' => $this->user->id,
            'status' => 'pending',
            'total' => 50.00,
            'uid' => 'ORD-20250101-1',
        ]);

        $order2 = Order::create([
            'user_id' => $this->user->id,
            'status' => 'confirmed',
            'total' => 100.00,
            'uid' => 'ORD-20250101-2',
        ]);

        $request = new Request([
            'search' => 'pending',
        ]);

        $orders = $this->orderService->getOrders($request);

        $this->assertCount(1, $orders);
        $this->assertEquals($order1->id, $orders->first()->id);
    }

    public function test_get_orders_with_status_filter(): void
    {
        Order::create([
            'user_id' => $this->user->id,
            'status' => 'pending',
            'total' => 50.00,
            'uid' => 'ORD-20250101-1',
        ]);

        Order::create([
            'user_id' => $this->user->id,
            'status' => 'confirmed',
            'total' => 100.00,
            'uid' => 'ORD-20250101-2',
        ]);

        $request = new Request([
            'status' => 'confirmed',
        ]);

        $orders = $this->orderService->getOrders($request);

        $this->assertCount(1, $orders);
        $this->assertEquals('confirmed', $orders->first()->status);
    }

    public function test_get_orders_with_pagination(): void
    {
        // Create multiple orders
        for ($i = 1; $i <= 15; $i++) {
            Order::create([
                'user_id' => $this->user->id,
                'status' => 'pending',
                'total' => 50.00,
                'uid' => "ORD-20250101-{$i}",
            ]);
        }

        $request = new Request([
            'per_page' => 10,
        ]);

        $orders = $this->orderService->getOrders($request);

        $this->assertCount(10, $orders);
        $this->assertEquals(15, $orders->total());
    }
}

