<?php

namespace Tests\Unit\Models\ProductVariation;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Pattern\Cart\Cart;
use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\Stock;
use App\Models\User;
use App\Models\Order;
use App\Models\PaymentMethod;

class ProductVariationTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_product_variation_in_stock()
    {
      $product = factory(ProductVariation::class)->create();

      $inStock = factory(Stock::class)->create([
        'product_variation_id' => $product->id
      ]);

      $this->assertTrue($product->inStock());
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_product_variation_has_weight_in_variations()
    {
      $product = factory(Product::class)->create([
        'weight' => 100
      ]);

      $product->variations()->saveMany([
        $one = factory(ProductVariation::class)->create([
            'weight' => 1000
        ]),
        $two = factory(ProductVariation::class)->create([
          'weight' => null
        ])
      ]);

      $this->assertEquals($one->weight, 1000);
      $this->assertEquals($two->weight, 100);
    }


    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_product_variations_min_stock()
    {
      $cart = new Cart(
        $user = factory(User::class)->create()
      );

      $product = factory(ProductVariation::class)->create();

      $cart->add([
        ['id' => $product->id, 'quantity' => 1]
      ]);

      $cart->sync();

      $this->assertdatabaseHas('cart_user', [
                    'product_variation_id' => $product->id,
                    'quantity' => 0
                  ]);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_product_variations_belongs_to_product_variation_order()
    {
      $cart = new Cart(
        $user = factory(User::class)->create()
      );


      $product = factory(Product::class)->create([
        'weight' => 100
      ]);

      $product->variations()->saveMany([
        $one = factory(ProductVariation::class)->create([
            'weight' => 1000
        ]),
        $two = factory(ProductVariation::class)->create([
          'weight' => null
        ])
      ]);

      $one->stocks()->save(
        factory(Stock::class)->make()
      );

      $two->stocks()->save(
        factory(Stock::class)->make()
      );

      $cart->add([
        ['id' => $one->id, 'quantity' => 1],
        ['id' => $two->id, 'quantity' => 1]
      ]);

      $user = $user->fresh();

      // dd($user->id);

      $order = factory(Order::class)->create([
        'user_id' => $user->id,
        'payment_method_id' => factory(PaymentMethod::class)->create()->id,
      ]);

      $order->products()->sync($user->cart->forSyncing());

      $this->assertdatabaseHas('product_variation_order', [
                    'quantity' => 1
                  ]);
    }
}
