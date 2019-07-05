<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;

trait HasSubdistrict
{
      /**
       * Scope a query to only include popular users.
       *
       * @param \Illuminate\Database\Eloquent\Builder $query
       * @return \Illuminate\Database\Eloquent\Builder
       */
    public function scopeHasSubdistrict(Builder $builder)
    {
        return $builder->whereHas('subdistricts');
    }
}
