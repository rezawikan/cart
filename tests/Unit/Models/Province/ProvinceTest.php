<?php

namespace Tests\Unit\Models\Province;

use App\Models\Subdistrict;
use App\Models\Province;
use App\Models\City;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProvinceTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_province_has_many_cities()
    {
        $province = factory(Province::class)->create();

          $province->cities()->saveMany([
            factory(City::class)->create(),
            factory(City::class)->create()
          ]);

          $this->assertdatabaseHas('cities', [
                      'province_id' => $province->id
                    ]);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_province_has_many_cities_in_different_way()
    {
        $province = factory(Province::class)->create();
        factory(City::class)->create([
          'province_id' => $province->id
        ]);
        factory(City::class)->create([
          'province_id' => $province->id
        ]);


        $this->assertEquals(count($province->cities->toArray()),2);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_province_has_many_through_subdistrict()
    {
        $province = factory(Province::class)->create();
        $city     = factory(City::class)->create([
          'province_id' => $province->id
        ]);

        factory(Subdistrict::class)->create([
          'city_id' => $city->id
        ]);
        factory(Subdistrict::class)->create([
          'city_id' => $city->id
        ]);

        $this->assertEquals(count($province->subdistricts->toArray()),2);
    }


}
