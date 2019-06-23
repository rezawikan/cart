<?php

namespace Tests\Feature\Products;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductVariation;
use App\Models\User;
use App\Models\Stock;
use App\Models\PaymentMethod;
use App\Models\Order;
use App\Pattern\Cart\Cart;
use Illuminate\Support\Facades\DB;

class ProductScopingTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_can_be_scope_by_category()
    {
        $product = factory(Product::class)->create();

        $product->categories()->save(
          $category = factory(Category::class)->create()
        );

        // $anotherProduct = factory(Product::class)->create();

        $this->json('GET',"api/products?slug={$category->slug}")
             ->assertJsonCount(1 , 'data');
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_can_be_scope_by_popular()
    {
        $cart1 = new Cart(
          $user1 = factory(User::class)->create()
        );

        $cart2 = new Cart(
          $user2 = factory(User::class)->create()
        );

        $product1 = factory(Product::class)->create([
          'weight' => 100
        ]);

        $product1->variations()->saveMany([
          $one = factory(ProductVariation::class)->create([
              'weight' => 1000
          ]),
          $two = factory(ProductVariation::class)->create([
            'weight' => null
          ])
        ]);

        $product2 = factory(Product::class)->create([
          'weight' => 100
        ]);

        $product2->variations()->saveMany([
          $one2 = factory(ProductVariation::class)->create([
              'weight' => 1000
          ]),
          $two2 = factory(ProductVariation::class)->create([
            'weight' => null
          ])
        ]);

        $one->stocks()->saveMany(
          factory(Stock::class,20)->make()
        );

        $two->stocks()->saveMany(
          factory(Stock::class,20)->make()
        );

        $one2->stocks()->saveMany(
          factory(Stock::class,20)->make()
        );

        $two2->stocks()->saveMany(
          factory(Stock::class,20)->make()
        );

        $cart1->add([
          ['id' => $one->id, 'quantity' => 4],
          ['id' => $two2->id, 'quantity' => 5],
          ['id' => $two->id, 'quantity' => 1]
        ]);

        $cart2->add([
          ['id' => $one->id, 'quantity' => 3],
          ['id' => $two2->id, 'quantity' => 1]
        ]);

        $user1 = $user1->fresh();
        $user2 = $user2->fresh();

        $order1 = factory(Order::class)->create([
          'user_id' => $user1->id,
          'payment_method_id' => factory(PaymentMethod::class)->create()->id,
        ]);

        $order2 = factory(Order::class)->create([
          'user_id' => $user2->id,
          'payment_method_id' => factory(PaymentMethod::class)->create()->id,
        ]);


        $order1->products()->sync($user1->cart->forSyncing());
        $order2->products()->sync($user2->cart->forSyncing());

        $this->json('GET',"api/products?popular=DESC")->assertStatus(200);
    }
}
