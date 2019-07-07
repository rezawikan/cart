<?php

namespace App\Models;

use App\Models\Subdistrict;
use App\Models\Traits\CanBeScoped;
use App\Models\Traits\LatestOrder;
use Illuminate\Database\Eloquent\Model;

class ShippingMethod extends Model
{
    use CanBeScoped, LatestOrder;
    protected $fillable = [
      'code',
      'type',
      'courier',
      'price',
      'estimation'
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
