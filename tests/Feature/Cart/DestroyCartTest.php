<?php

namespace Tests\Feature\Cart;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\ProductVariation;

class DestroyCartTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_fails_if_unauthenticated()
    {
        $response = $this->json('DELETE', 'api/cart/1')
                       ->assertStatus(401);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_product_cant_be_found()
    {
        $user = factory(User::class)->create();

        $response = $this->jsonAs($user, 'DELETE', 'api/cart/1')
                         ->assertStatus(404);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_product_cant_be_delete()
    {
        $user = factory(User::class)->create();

        $user->cart()->attach(
          $product = factory(ProductVariation::class)->create(), [
            'quantity' => 1
          ]
        );

        $response = $this->jsonAs($user, 'DELETE', "api/cart/{$product->id}")
                         ->assertStatus(200);
    }
}
