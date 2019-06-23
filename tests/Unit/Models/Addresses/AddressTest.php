<?php

namespace Tests\Unit\Models\Addresses;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Country;
use App\Models\User;
use App\Models\Address;
use App\Models\Subdistrict;

class AddressTest extends TestCase
{

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_belongs_to_a_user()
    {
        $address = factory(Address::class)->create([
          'user_id' => factory(User::class)->create()->id
        ]);

        $this->assertInstanceOf(User::class, $address->user);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_address_has_one_subdistrict()
    {
        $subdistrict = factory(Subdistrict::class)->create();
        $address = factory(Address::class)->create([
          'user_id' => factory(User::class)->create()->id,
          'subdistrict_id' => $subdistrict->id
        ]);

        $this->assertEquals($address->subdistrict->name, $subdistrict->name);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_sets_old_addresses_to_not_default_when_creating()
    {
        $user =  factory(User::class)->create();

        $oldAddress = factory(Address::class)->create([
          'default' => true,
          'user_id' => $user->id
        ]);

        factory(Address::class)->create([
          'default' => true,
          'user_id' => $user->id
        ]);

        $this->assertEquals($oldAddress->fresh()->default,0);
    }
}
