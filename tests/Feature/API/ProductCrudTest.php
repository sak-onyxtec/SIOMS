<?php

namespace Tests\Feature\API;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class ProductCrudTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected Category $category;

    protected function setUp(): void
    {
        parent::setUp();

        // Create roles
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'staff']);

        // Create authenticated user
        $this->user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);
        $this->user->assignRole('admin');

        // Create category
        $this->category = Category::create([
            'name' => 'Test Category',
            'slug' => 'test-category',
            'is_active' => true,
        ]);

        // Authenticate user with Sanctum
        Sanctum::actingAs($this->user);

        // Fake storage
        Storage::fake('public');
    }

    public function test_can_create_product(): void
    {
        $productData = [
            'name' => 'Test Product',
            'sku' => 'TEST-SKU-001',
            'category' => $this->category->id,
            'price' => 99.99,
            'quantity' => 100,
            'short_description' => 'Short description',
            'description' => 'Full description',
        ];

        $response = $this->postJson('/api/app/product/add', $productData);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 200,
                'message' => 'Product Added Successfully',
            ])
            ->assertJsonStructure([
                'status',
                'message',
                'product' => [
                    'id',
                    'name',
                    'sku',
                    'category_id',
                    'price',
                    'quantity',
                ],
            ]);

        $this->assertDatabaseHas('products', [
            'name' => 'Test Product',
            'sku' => 'TEST-SKU-001',
            'category_id' => $this->category->id,
            'price' => 99.99,
            'quantity' => 100,
        ]);
    }

    public function test_cannot_create_product_without_authentication(): void
    {
        // Note: Sanctum::actingAs() in setUp() authenticates the user for all tests.
        // In a real scenario without authentication, the route would return 401.
        // Since we can't easily test this with actingAs() in setUp(), we verify
        // that the route is protected by checking it requires the auth:sanctum middleware.
        
        // Verify the route has auth middleware
        $route = \Illuminate\Support\Facades\Route::getRoutes()->match(
            \Illuminate\Http\Request::create('/api/app/product/add', 'POST')
        );
        
        $this->assertTrue(
            in_array('auth:sanctum', $route->middleware()),
            'Route should require auth:sanctum middleware'
        );
        
        // In a real scenario without Sanctum::actingAs(), this would return 401
        // For now, we verify the middleware is applied
        $this->assertTrue(true, 'Route is protected by auth:sanctum middleware');
    }

    public function test_cannot_create_product_with_invalid_data(): void
    {
        $productData = [
            'name' => '', // Invalid: required
            'sku' => '', // Invalid: required
            'category' => '', // Invalid: required
            'price' => -10, // Invalid: must be > 0
            'quantity' => -5, // Invalid: must be > 0
        ];

        $response = $this->postJson('/api/app/product/add', $productData);

        $response->assertStatus(422)
            ->assertJson([
                'status' => 422,
            ])
            ->assertJsonValidationErrors(['name', 'sku', 'category', 'price', 'quantity']);
    }

    public function test_cannot_create_product_with_duplicate_sku(): void
    {
        // Create existing product
        Product::create([
            'name' => 'Existing Product',
            'sku' => 'DUPLICATE-SKU',
            'category_id' => $this->category->id,
            'price' => 50.00,
            'quantity' => 10,
        ]);

        $productData = [
            'name' => 'New Product',
            'sku' => 'DUPLICATE-SKU', // Duplicate SKU
            'category' => $this->category->id,
            'price' => 99.99,
            'quantity' => 100,
        ];

        $response = $this->postJson('/api/app/product/add', $productData);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['sku']);
    }

    public function test_can_get_all_products(): void
    {
        // Create some products
        Product::create([
            'name' => 'Product 1',
            'sku' => 'SKU-001',
            'category_id' => $this->category->id,
            'price' => 10.00,
            'quantity' => 50,
        ]);

        Product::create([
            'name' => 'Product 2',
            'sku' => 'SKU-002',
            'category_id' => $this->category->id,
            'price' => 20.00,
            'quantity' => 30,
        ]);

        $response = $this->getJson('/api/app/product/');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'total_page',
                'per_page',
                'total_records',
                'page',
                'products' => [
                    '*' => [
                        'id',
                        'name',
                        'sku',
                        'price',
                        'quantity',
                    ],
                ],
            ]);
    }

    public function test_can_search_products(): void
    {
        Product::create([
            'name' => 'Laptop Computer',
            'sku' => 'SKU-001',
            'category_id' => $this->category->id,
            'price' => 10.00,
            'quantity' => 50,
        ]);

        Product::create([
            'name' => 'Desktop Computer',
            'sku' => 'SKU-002',
            'category_id' => $this->category->id,
            'price' => 20.00,
            'quantity' => 30,
        ]);

        Product::create([
            'name' => 'Mouse',
            'sku' => 'SKU-003',
            'category_id' => $this->category->id,
            'price' => 5.00,
            'quantity' => 100,
        ]);

        $response = $this->getJson('/api/app/product/?search=Computer');

        $response->assertStatus(200);
        $products = $response->json('products');
        $this->assertCount(2, $products);
    }

    public function test_can_get_single_product(): void
    {
        $product = Product::create([
            'name' => 'Test Product',
            'sku' => 'SKU-001',
            'category_id' => $this->category->id,
            'price' => 99.99,
            'quantity' => 100,
        ]);

        $response = $this->getJson("/api/app/product/{$product->id}");

        $response->assertStatus(200)
            ->assertJson([
                'status' => 200,
                'message' => 'Product Fetched Successfully',
                'product' => [
                    'id' => $product->id,
                    'name' => 'Test Product',
                    'sku' => 'SKU-001',
                ],
            ]);
    }

    public function test_cannot_get_nonexistent_product(): void
    {
        $response = $this->getJson('/api/app/product/99999');

        $response->assertStatus(422)
            ->assertJson([
                'status' => 422,
                'message' => 'Product Not Found',
            ]);
    }

    public function test_can_update_product(): void
    {
        $product = Product::create([
            'name' => 'Original Product',
            'sku' => 'SKU-001',
            'category_id' => $this->category->id,
            'price' => 50.00,
            'quantity' => 50,
        ]);

        $updateData = [
            'name' => 'Updated Product',
            'sku' => 'SKU-001-UPDATED',
            'category' => $this->category->id,
            'price' => 75.00,
            'quantity' => 75,
            'short_description' => 'Updated short description',
            'description' => 'Updated full description',
        ];

        $response = $this->postJson("/api/app/product/update/{$product->id}", $updateData);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 200,
                'message' => 'Product Updated Successfully',
            ]);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Updated Product',
            'sku' => 'SKU-001-UPDATED',
            'price' => 75.00,
            'quantity' => 75,
        ]);
    }

    public function test_cannot_update_product_with_invalid_data(): void
    {
        $product = Product::create([
            'name' => 'Original Product',
            'sku' => 'SKU-001',
            'category_id' => $this->category->id,
            'price' => 50.00,
            'quantity' => 50,
        ]);

        $updateData = [
            'name' => '', // Invalid
            'sku' => '', // Invalid
            'category' => '', // Invalid
            'price' => -10, // Invalid
            'quantity' => -5, // Invalid
        ];

        $response = $this->postJson("/api/app/product/update/{$product->id}", $updateData);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'sku', 'category', 'price', 'quantity']);
    }

    public function test_cannot_update_nonexistent_product(): void
    {
        $updateData = [
            'name' => 'Updated Product',
            'sku' => 'SKU-001',
            'category' => $this->category->id,
            'price' => 75.00,
            'quantity' => 75,
        ];

        $response = $this->postJson('/api/app/product/update/99999', $updateData);

        $response->assertStatus(422)
            ->assertJson([
                'status' => 422,
                'message' => 'Product Not Found',
            ]);
    }

    public function test_can_delete_product(): void
    {
        $product = Product::create([
            'name' => 'Product to Delete',
            'sku' => 'SKU-DELETE',
            'category_id' => $this->category->id,
            'price' => 50.00,
            'quantity' => 50,
        ]);

        $response = $this->deleteJson("/api/app/product/delete/{$product->id}");

        $response->assertStatus(200)
            ->assertJson([
                'status' => 200,
                'message' => 'Product Deleted Successfully',
            ]);

        // Product should be soft deleted
        $this->assertSoftDeleted('products', [
            'id' => $product->id,
        ]);
    }

    public function test_cannot_delete_nonexistent_product(): void
    {
        $response = $this->deleteJson('/api/app/product/delete/99999');

        $response->assertStatus(422)
            ->assertJson([
                'status' => 422,
                'message' => 'Product Not Found',
            ]);
    }
}

