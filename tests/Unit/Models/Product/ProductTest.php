<?php

namespace Tests\Unit\Models\Product;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Stock;
use App\Models\Product;
use App\Pattern\Cart\Money;
use App\Models\Category;
use App\Models\ProductVariation;

class ProductTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_uses_the_slug_for_the_route_key_name()
    {
        $product = new Product();

        $this->assertEquals($product->getRouteKeyName(), 'slug');
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_has_many_categories()
    {
        $product = factory(Product::class)->create();

        $product->categories()->save(
          factory(Category::class)->create()
        );

        $this->assertInstanceOf(Category::class, $product->categories()->first());
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_has_many_variations()
    {
        $product = factory(Product::class)->create();

        $product->variations()->saveMany([
          factory(ProductVariation::class)->create([
              'price' => 1000
          ]),
          factory(ProductVariation::class)->create([
              'price' => 2000
          ])
        ]);

        $this->assertTrue($product->varies());
        $this->assertInstanceOf(ProductVariation::class, $product->variations()->first());
    }

    // /**
    //  * A basic test example.
    //  *
    //  * @return void
    //  */
    // public function test_it_returns_a_money_instance_the_price()
    // {
    //     $variation = factory(ProductVariation::class)->create();
    //
    //     $this->assertInstanceOf(Money::class, $variation->price);
    // }

    /**
     * A basic test example.
     *
     * @return void
     */
    // public function test_it_returns_a_formatted_price()
    // {
    //     $variation = factory(ProductVariation::class)->create([
    //       'price' => 1000
    //     ]);
    //
    //     $this->assertEquals($variation->formattedPrice, 'Rp10');
    // }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_returns_the_product_price_if_price_is_null()
    {
        $product = factory(Product::class)->create([
          'price' => 1000
        ]);

        $variation = factory(ProductVariation::class)->create([
          'price' => null,
          'product_id' => $product->id
        ]);

        $this->assertEquals($product->price, $variation->price);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_checking_variations_price()
    {
        $product = factory(Product::class)->create([
          'price' => 1000
        ]);

        $variation = factory(ProductVariation::class)->create([
          'price' => 2000,
          'product_id' => $product->id
        ]);

        $this->assertTrue($variation->priceVaries());
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_has_many_stocks()
    {
        $variation = factory(ProductVariation::class)->create();

        $variation->stocks()->save(
          factory(Stock::class)->make()
        );

        $this->assertInstanceOf(Stock::class, $variation->stocks->first());
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_has_stock_information()
    {
        $variation = factory(ProductVariation::class)->create();

        $variation->stocks()->save(
          factory(Stock::class)->make()
        );

        $this->assertInstanceOf(ProductVariation::class, $variation->stock->first());
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_has_stock_count_pivot_within_stock_information()
    {
        $variation = factory(ProductVariation::class)->create();

        $variation->stocks()->save(
          factory(Stock::class)->make([
            'quantity' => $quantity = 5
          ])
        );

        $this->assertEquals($variation->stock->first()->pivot->stock, $quantity );
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_has_in_stock_within_stock_information()
    {
        $variation = factory(ProductVariation::class)->create();

        $variation->stocks()->save(
          factory(Stock::class)->make()
        );

        $this->assertEquals($variation->stock->first()->pivot->in_stock, 1);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_can_checks_if_its_in_stcok()
    {
        $variation = factory(ProductVariation::class)->create();

        $variation->stocks()->save(
          factory(Stock::class)->make([
            'quantity' => $quantity = 5
          ])
        );

        $this->assertEquals($variation->stockCount(), $quantity);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_can_checks_if_its_in_stocks()
    {
        $product = factory(Product::class)->create();

        $product->variations()->save(
          $variation = factory(ProductVariation::class)->create()
        );

        $variation->stocks()->save(
          factory(Stock::class)->make()
        );

        // dd();

        $this->assertTrue($product->inStock());
    }
}
