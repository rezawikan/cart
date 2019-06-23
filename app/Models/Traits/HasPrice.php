<?php

namespace App\Models\Traits;

use App\Pattern\Cart\Money;
use Illuminate\Database\Eloquent\Builder;

trait HasPrice
{
    public function getPriceAttribute($value)
    {
        return $value;
    }

    public function getFormattedPriceAttribute()
    {
        // return $this->price->formatted();
    }
}
