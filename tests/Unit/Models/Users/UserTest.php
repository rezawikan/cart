<?php

namespace Tests\Unit\Models\Users;

use Tests\TestCase;
use App\Models\User;
use App\Models\Address;
use App\Models\ProductVariation;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_hashes_the_password_when_creating()
    {
        $user = factory(User::class)->create([
          'password' => 'testing'
        ]);

        $this->assertNotEquals($user->password, 'testing');
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_has_many_cart_products()
    {
        $user = factory(User::class)->create();

        $user->cart()->attach(
          factory(ProductVariation::class)->create()
        );

        $this->assertInstanceOf(ProductVariation::class, $user->cart->first());
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_has_quantity_of_each_cart()
    {
        $user = factory(User::class)->create();

        $user->cart()->attach(
          factory(ProductVariation::class)->create(), [
            'quantity' => $quantity = 5
          ]
        );

        $this->assertEquals($user->cart->first()->pivot->quantity, $quantity);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_has_many_addresses()
    {
        $user = factory(User::class)->create();

        $user->addresses()->save(
          factory(Address::class)->make()
        );

        $this->assertInstanceOf(Address::class, $user->addresses()->first());
    }
}
