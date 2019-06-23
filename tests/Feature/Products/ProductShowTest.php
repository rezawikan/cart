<?php

namespace Tests\Feature\Products;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Product;

class ProductShowTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_fails_if_a_product_cant_be_found()
    {
        $this->json('GET','api/products/nope')
             ->assertStatus(404);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_shows_a_product()
    {
        $product = factory(Product::class)->create();

        $this->json('GET',"api/products/{$product->slug}")
             ->assertJsonFragment([
               'id' => $product->id
             ]);
    }
}
