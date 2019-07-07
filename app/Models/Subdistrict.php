<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\City;
use App\Models\Province;
use App\Models\ShippingMethod;
use App\Models\Traits\CanBeScoped;
use App\Models\Traits\LatestOrder;
use App\Models\Traits\OrderByProvince;
use App\Models\Traits\HasShippingMethod;

class Subdistrict extends Model
{
    use CanBeScoped, LatestOrder, HasShippingMethod, OrderByProvince;

    protected $fillable = [
      'city_id',
      'name'
    ];

    /**
    * Get the comments for the blog post.
    */
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    /**
    * Get the comments for the blog post.
    */
    public function shippingMethods()
    {
        return $this->belongsToMany(ShippingMethod::class);
    }
}
