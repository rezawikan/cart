<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use  App\Models\Collection\ProductVariationCollection;
use App\Models\ProductVariationType;
use App\Models\Traits\HasPrice;
use App\Models\Traits\CanBeScoped;
use App\Models\Traits\LatestOrder;
use App\Models\Stock;
use App\Pattern\Cart\Money;
use App\Models\Order;
use App\Models\Returns;

class ProductVariation extends Model
{
    use CanBeScoped, HasPrice, LatestOrder;

    protected $fillable = [
      'product_id',
      'product_variation_type_id',
      'name',
      'price',
      'order',
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
        return 'id';
    }

    /**
     * Block comment
     *
     * @param type
     * @return void
     */
    public function getPriceAttribute($value)
    {
        if ($value === null) {
            return $this->product->price;
        }

        return $value;
    }

    /**
     * Block comment
     *
     * @param type
     * @return void
     */
    public function getBasePriceAttribute($value)
    {
        if ($value === null) {
            return $this->product->base_price;
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
        if ($value === null) {
            return $this->product->weight;
        }

        return $value;
    }

    public function minStock($amount)
    {
        return min($this->stockCount(), $amount);
    }

    /**
     * Block comment
     *
     * @param type
     * @return void
     */
    public function type()
    {
        return $this->hasOne(ProductVariationType::class, 'id', 'product_variation_type_id');
    }

    /**
     * Block comment
     *
     * @param type
     * @return void
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Block comment
     *
     * @param type
     * @return void
     */
    public function returns()
    {
        return $this->hasMany(Returns::class);
    }

    /**
     * Block comment
     *
     * @param type
     * @return void
     */
    public function priceVaries()
    {
        return $this->price !== $this->product->price;
    }

    /**
     * Block comment
     *
     * @param type
     * @return void
     */
    public function orders()
    {
        return $this->belongsToMany(ProductVariation::class, 'product_variation_order');
    }

    /**
     * Block comment
     *
     * @param type
     * @return void
     */
    public function carts()
    {
        return $this->belongsToMany(ProductVariation::class, 'cart_user');
    }

    /**
     * Block comment
     *
     * @param type
     * @return void
     */
    public function deleteable()
    {

        return $this->orders()->count() < 1 && $this->carts()->count() < 1 ;
    }

    /**
     * Block comment
     *
     * @param type
     * @return void
     */
    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    /**
     * Block comment
     *
     * @param type
     * @return void
     */
    public function hasStock()
    {
        return count($this->stocks) > 0 ? true : false ;
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

    /**
     * Block comment
     *
     * @param type
     * @return void
     */
    public function stockCount()
    {
        return $this->stock->sum('pivot.stock')  ;
    }

    /**
     * Block comment
     *
     * @param type
     * @return void
     */
    public function stock()
    {
        return $this->belongsToMany(
          ProductVariation::class,
          'product_variation_stock_view'
        )->withPivot([
          'stock',
          'in_stock'
        ]);
    }
    /**
       * Get the phone record associated with the user.
       */
    public function newCollection(array $models = [])
    {
        return new ProductVariationCollection($models);
    }
}
