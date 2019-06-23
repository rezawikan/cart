<?php

namespace Tests\Feature\Products;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Product;

class ProductIndexTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_shows_a_collection_of_products()
    {
        $product = factory(Product::class)->create();

        $this->json('GET','api/products')
             ->assertJsonFragment([
               'id' => $product->id
             ]);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_has_paginated_data()
    {
        $this->json('GET','api/products')
             ->assertJsonStructure([
               'links',
               'meta',
               'data'
             ]);
    }
}
