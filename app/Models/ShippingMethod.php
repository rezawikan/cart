<?php

namespace App\Models;

use App\Models\Subdistrict;
use Illuminate\Database\Eloquent\Model;

class ShippingMethod extends Model
{
    protected $fillable = [
      'code',
      'type',
      'courier',
      'price'
    ];
    
    public function subdistricts()
    {
      return $this->belongsToMany(Subdistrict::class);
    }
}
