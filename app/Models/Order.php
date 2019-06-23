<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Address;
use App\Models\ShippingMethod;
use App\Models\ProductVariation;
use App\Models\paymentMethod;

class Order extends Model
{
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

        static::creating(function ($order) {
            $order->status = self::PENDING;
        });
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
}
