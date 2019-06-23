<?php

namespace Tests\Unit\Models\Categories;

use App\Models\Product;
use App\Models\Category;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_has_many_children()
    {
        $category = factory(Category::class)->create();

        $category->children()->save(
          factory(Category::class)->create()
        );

        $this->assertInstanceOf(Category::class, $category->children()->first());
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_can_fetch_only_parent()
    {
        $category = factory(Category::class)->create();

        $category->children()->save(
          factory(Category::class)->create()
        );

        $this->assertEquals(1, Category::parents()->count());
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_is_orderable_by_a_numbered_order()
    {
        $category = factory(Category::class)->create([
          'order' => 2
        ]);

        $otherCategory = factory(Category::class)->create([
          'order' => 1
        ]);

        $this->assertEquals($otherCategory->name, Category::ordered()->first()->name);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_has_may_products()
    {
        $category = factory(Category::class)->create();

        $category->products()->save(
          factory(Product::class)->create()
        );

        $this->assertInstanceOf(Product::class, $category->products->first());
    }
}
