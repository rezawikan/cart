<?php

namespace Tests\Feature\Products;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Pattern\Cart\Money;
use App\Models\Stock;
use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\ProductVariationType;

class ProductVariationTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_has_one_variation_type()
    {
        $variation = factory(ProductVariation::class)->create();

        $this->assertInstanceOf(ProductVariationType::class, $variation->type);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_belongs_to_a_product()
    {
        $variation = factory(ProductVariation::class)->create();

        $this->assertInstanceOf(Product::class, $variation->product);
    }

    // /**
    //  * A basic test example.
    //  *
    //  * @return void
    //  */
    // public function test_it_returns_a_money_instance_the_price()
    // {
    //     $product = factory(Product::class)->create();
    //
    //     $this->assertInstanceOf(Money::class, $product->price);
    // }

    /**
     * A basic test example.
     *
     * @return void
     */
    // public function test_it_returns_a_formatted_price()
    // {
    //     $product = factory(Product::class)->create([
    //       'price' => 1000
    //     ]);
    //
    //     $this->assertEquals($product->formattedPrice, 'Rp10');
    // }

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
}
