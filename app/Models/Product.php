<?php

namespace App\Models;

use App\Models\Category;
use App\Models\Image;
use App\Models\ProductVariation;
use App\Models\ProductVariationType;
use App\Models\Traits\CanBeScoped;
use App\Models\Traits\HasPrice;
use App\Models\Traits\LatestOrder;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Product extends Model
{
    use CanBeScoped, HasPrice, LatestOrder;

    protected $fillable = [
      'name',
      'slug',
      'price',
      'description',
      'weight',
      'base_price'
    ];

    /**
    * Get the route key for the model.
    *
    * @return string
    */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Block comment
     *
     * @param type
     * @return void
     */
    public function getPriceAttribute($value)
    {
        if ($this->variations) {
            $price = $this->variations->map(function($variant){
                return $variant->price;
            })->toArray();

            return [
              'min' => min($price),
              'max' => max($price)
            ];
        }

        return $value;
    }

    /**
     * Block comment
     *
     * @param type
     * @return void
     */
    public function getWeightAttribute($value)
    {
        if ($this->variations) {
            $weight = $this->variations->map(function($variant){
                return $variant->weight;
            })->toArray();

            return [
              'min' => min($weight),
              'max' => max($weight)
            ];
        }

        return $value;
    }

    /**
     * Get all of the posts for the country.
     */
    public function type()
    {
        return $this->hasManyThrough(ProductVariationType::class, ProductVariation::class);
    }

    /**
     * Scope a query to only include popular users.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * Scope a query to only include popular users.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function variations()
    {
        return $this->hasMany(ProductVariation::class)->orderBy('order', 'asc');
    }


    /**
     * Block comment
     *
     * @param type
     * @return void
     */
    public function images()
    {
        return $this->hasMany(Image::class);
    }

    /**
     * Block comment
     *
     * @param type
     * @return void
     */
    public function stockCount()
    {
        return $this->variations->sum(function ($variation) {
            return $variation->stockCount();
        });
    }

    /**
     * Block comment
     *
     * @param type
     * @return void
     */
    public function varies()
    {
         $array =  $this->variations->map(function ($variation) {
            return $variation->priceVaries();
        });

        if (in_array(true, $array->toArray())) {
            return true;
        }

        return false;
    }

    /**
     * Block comment
     *
     * @param type
     * @return void
     */
    public function inStock()
    {
        return $this->stockCount() > 0;
    }
}
