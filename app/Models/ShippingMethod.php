<?php

namespace App\Models;

use App\Models\Subdistrict;
use App\Models\Traits\CanBeScoped;
use App\Models\Traits\LatestOrder;
use App\Models\Traits\HasSubdistrict;
use App\Models\Traits\OrderByProvince;
use Illuminate\Database\Eloquent\Model;

class ShippingMethod extends Model
{
    use CanBeScoped, LatestOrder, HasSubdistrict, OrderByProvince;
    protected $fillable = [
      'code',
      'type',
      'courier',
      'price'
    ];

    /**
     * Block comment
     *
     * @param type
     * @return void
     */
    public function subdistricts()
    {
      return $this->belongsToMany(Subdistrict::class);
    }
}
