<?php

namespace Tests\Unit\Cart;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Pattern\Cart\Cart;
use App\Models\User;
use App\Models\ProductVariation;

class CartTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_can_be_add_products_to_cart()
    {
        $cart = new Cart(
          $user = factory(User::class)->create()
        );

        $product = factory(ProductVariation::class)->create();

        $cart->add([
          ['id' => $product->id, 'quantity' => 1]
        ]);

        $this->assertCount(1, $user->fresh()->cart);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_requires_an_array_products()
    {
        $user = factory(User::class)->create();

        $response = $this->jsonAs($user, 'POST', 'api/cart', [
          'products' => [
            ['quantity' => 1]
          ]
        ])->assertJsonValidationErrors(['products.0.id']);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_requires_product_to_exists()
    {
        $user = factory(User::class)->create();

        $response = $this->jsonAs($user, 'POST', 'api/cart', [
          'products' => [
            ['id' => 100 , 'quantity' => 1]
          ]
        ])->assertJsonValidationErrors(['products.0.id']);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_requires_product_quantity_to_be_numeric()
    {
        $user = factory(User::class)->create();

        $response = $this->jsonAs($user, 'POST', 'api/cart', [
          'products' => [
            ['id' => 100 , 'quantity' => 'one']
          ]
        ])->assertJsonValidationErrors(['products.0.quantity']);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_requires_product_quantity_at_least_one()
    {
        $user = factory(User::class)->create();

        $response = $this->jsonAs($user, 'POST', 'api/cart', [
          'products' => [
            ['id' => 100 , 'quantity' => 0]
          ]
        ])->assertJsonValidationErrors(['products.0.quantity']);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_can_be_add_to_user_cart()
    {
        $user = factory(User::class)->create();

        $product = factory(ProductVariation::class)->create();

        $response = $this->jsonAs($user, 'POST', 'api/cart', [
          'products' => [
            ['id' => $product->id , 'quantity' => 1]
          ]
        ]);

        $this->assertDatabaseHas('cart_user', [
            'product_variation_id' => $product->id,
            'quantity' => 1
          ]);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_can_be_increments_quantity_when_adding_more_products()
    {
        $product = factory(ProductVariation::class)->create();

        $cart = new Cart(
          $user = factory(User::class)->create()
        );

        $cart->add([
            ['id' => $product->id , 'quantity' => 2 ]
        ]);

        $cart = new Cart(
          $user->fresh()
        );

        $cart->add([
            ['id' => $product->id, 'quantity' => 2 ]
        ]);

        $this->assertEquals(4, $user->fresh()->cart->first()->pivot->quantity);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_can_delete_product()
    {
        $cart = new Cart(
          $user = factory(User::class)->create()
        );

        $user->cart()->attach(
            $product = factory(ProductVariation::class)->create(), [
              'quantity' => 2
            ]
          );

        $cart->delete($product->id);

        $this->assertCount(0, $user->fresh()->cart);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_can_empty_product()
    {
        $cart = new Cart(
          $user = factory(User::class)->create()
        );

        $user->cart()->attach(
            $product = factory(ProductVariation::class)->create()
          );

        $cart->empty();

        $this->assertCount(0, $user->fresh()->cart);
    }
}
