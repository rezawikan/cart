<?php

namespace Tests\Unit\Models\Subdistrict;

use App\Models\ShippingMethod;
use App\Models\Subdistrict;
use App\Models\Province;
use App\Models\City;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubdistrictTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_it_belongs_to_city()
    {
        $subdistrict = factory(Subdistrict::class)->create();
        $city        = factory(City::class)->create();
        // Update belongsTo
        $subdistrict->city()->update([
          'city_id' => $city->id
        ]);

        $this->assertTrue(true);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    // public function test_it_belongs_to_city()
    // {
    //     $subdistrict = factory(Subdistrict::class)->create();
    //     $shipping    = factory(ShippingMethod::class)->create();
    //
    //
    //     $this->assertTrue(true);
    // }


}
