<?php

namespace Tests\Feature\Cart;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\ProductVariation;

class CartUpdateTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_fails_if_unauthenticated()
    {
        $response = $this->json('PATCH', 'api/cart/1')
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

        $response = $this->jsonAs($user, 'PATCH', 'api/cart/1')
                         ->assertStatus(404);
    }


    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_product_requires_quantity()
    {
        $user = factory(User::class)->create();

        $product = factory(ProductVariation::class)->create();

        $response = $this->jsonAs($user, 'PATCH', "api/cart/{$product->id}", [
              'quantity' => 0
            ])->assertJsonValidationErrors(['quantity']);
    }


    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_can_update_the_quantity_of_product()
    {
        $user = factory(User::class)->create();

        $user->cart()->attach(
          $product = factory(ProductVariation::class)->create(),
            [
            'quantity' => 1
          ]
        );

        $response = $this->jsonAs($user, 'PATCH', "api/cart/{$product->id}", [
                      'quantity' => 5
                    ]);

        $this->assertdatabaseHas('cart_user', [
                      'product_variation_id' => $product->id,
                      'quantity' => 5
                    ]);
    }
}
