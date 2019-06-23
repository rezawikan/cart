<?php

namespace Tests\Feature\Cart;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Pattern\Cart\Cart;
use App\Models\ProductVariation;

class CartStoreTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_fails_it_unauthenticated()
    {
        $response = $this->json('POST', 'api/cart')
        ->assertStatus(401);
    }


    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_required_product_details()
    {
        $user = factory(User::class)->create();

        $response = $this->jsonAs($user, 'POST', 'api/cart', [
          'products' => 1
        ])
        ->assertJsonValidationErrors(['products']);
    }

    
}
