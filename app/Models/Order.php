<?php

namespace App\Models;

use App\Models\User;
use App\Models\Address;
use App\Models\paymentMethod;
use App\Models\ShippingMethod;
use App\Models\ProductVariation;
use App\Models\Traits\CanBeScoped;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use CanBeScoped;

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
      'total'
    ];

    public static function boot()
    {
        parent::boot();

        // static::created(function ($order) {
        //     $order->status = self::PENDING;
        // });
    }

    public function total()
    {
      return $this->subtotal + $this->shippingMethod->price;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function shippingMethod()
    {
        return $this->belongsTo(shippingMethod::class);
    }

    public function paymentMethod()
    {
        return $this->belongsTo(paymentMethod::class);
    }

    public function products()
    {
        return $this->belongsToMany(ProductVariation::class, 'product_variation_order')
                ->withPivot(['quantity'])
                ->withTimestamps();
    }

    public function revenue()
    {
        return $this->base_subtotal - $this->discount;
    }
}
