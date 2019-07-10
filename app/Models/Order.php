<?php

namespace App\Models;

use App\Models\User;
use App\Models\Returns;
use App\Models\Address;
use App\Models\PaymentMethod;
use App\Models\ShippingMethod;
use App\Models\ProductVariation;
use App\Models\Traits\Timeable;
use App\Models\Traits\CanBeScoped;
use App\Models\Traits\LatestOrder;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use CanBeScoped, Timeable, LatestOrder;

    const PENDING = 'pending';
    const PROCESSING = 'processing';
    const PAYMENT_FAILED = 'payment_failed';
    const COMPLETED = 'completed';

    protected $fillable = [
      'user_id',
      'status',
      'address_id',
      'shipping_method_id',
      'payment_method_id',
      'subtotal',
      'base_subtotal',
      'discount',
      'total',
      'created_at'
    ];

    /**
     * Block comment
     *
     * @param type
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        // static::created(function ($order) {
        //     $order->status = self::PENDING;
        // });
    }

    /**
     * Block comment
     *
     * @param type
     * @return void
     */
    public function total()
    {
        return $this->subtotal + $this->shippingMethod->price;
    }

    /**
     * Block comment
     *
     * @param type
     * @return void
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Block comment
     *
     * @param type
     * @return void
     */
    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    /**
     * Block comment
     *
     * @param type
     * @return void
     */
    public function shippingMethod()
    {
        return $this->belongsTo(shippingMethod::class);
    }

    /**
     * Block comment
     *
     * @param type
     * @return void
     */
    public function paymentMethod()
    {
        return $this->belongsTo(paymentMethod::class);
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
    public function products()
    {
        return $this->belongsToMany(ProductVariation::class, 'product_variation_order')
                ->withPivot(['quantity','status'])
                ->withTimestamps();
    }

    /**
     * Block comment
     *
     * @param type
     * @return void
     */
    public function revenue()
    {
        return $this->base_subtotal - $this->discount;
    }

    public function newSubTotal()
    {
        return $this->products->sum(function ($product) {
            return $product->price * $product->pivot->quantity;
        });
    }

    public function newBaseSubTotal()
    {
        return $this->products->sum(function ($product) {
            return $product->base_price * $product->pivot->quantity;
        });
    }

    public function newTotal()
    {
        return ($this->newSubTotal() - $this->discount) + $this->shippingMethod->price;
    }
}
