<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;

trait OrderByProvince
{
      /**
       * Scope a query to only include popular users.
       *
       * @param \Illuminate\Database\Eloquent\Builder $query
       * @return \Illuminate\Database\Eloquent\Builder
       */
    public function scopeOrderByProvince(Builder $builder, $value = 'asc')
    {
        return $builder->whereHas('subdistricts', function($builder) use ($value){
          return $builder->whereHas('city', function($builder)  use ($value){
            return $builder->whereHas('province', function($builder)  use ($value){
              return $builder->orderBy('name', $value);
            });
          });
        });
    }
}
