<?php

namespace Tests\Feature;

use App\Models\Cart;
use App\Models\Customer;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_shows_real_data_from_the_database(): void
    {
        Schema::create('product', function ($table) {
            $table->id('product_id');
            $table->unsignedBigInteger('category_id');
            $table->string('product_name', 100);
            $table->decimal('price', 10, 2);
            $table->integer('stock_quantity');
            $table->text('description')->nullable();
            $table->string('image', 255)->nullable();
            $table->timestamps();
        });

        Schema::create('customers', function ($table) {
            $table->id('customer_id');
            $table->string('customer_name', 100);
            $table->string('phone', 30)->nullable();
            $table->string('email', 120)->nullable();
            $table->text('address')->nullable();
            $table->unsignedInteger('total_orders')->default(0);
            $table->decimal('total_spent', 10, 2)->default(0);
            $table->timestamp('last_order_at')->nullable();
            $table->timestamps();
        });

        Schema::create('carts', function ($table) {
            $table->id('Order_id');
            $table->unsignedBigInteger('product_id');
            $table->string('customer_name', 100);
            $table->integer('quantity');
            $table->decimal('total_price', 8, 2);
            $table->timestamps();
        });

        $user = User::factory()->create();

        $product = Product::create([
            'category_id' => 1,
            'product_name' => 'Latte',
            'price' => 4.50,
            'stock_quantity' => 3,
            'description' => 'Creamy latte',
        ]);

        Customer::create([
            'customer_name' => 'Alice',
            'phone' => '1234',
            'email' => 'alice@example.com',
            'address' => 'Main Street',
            'total_orders' => 1,
            'total_spent' => 4.50,
        ]);

        Cart::create([
            'product_id' => $product->product_id,
            'product_name' => $product->product_name,
            'customer_name' => 'Alice',
            'quantity' => 1,
            'total_price' => 4.50,
        ]);

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Latte');
        $response->assertSee('Alice');
        $response->assertSee('$4.50');
    }
}
