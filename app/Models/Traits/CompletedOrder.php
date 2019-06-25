<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;

trait CompletedOrder
{
      /**
       * Scope a query to only include popular users.
       *
       * @param \Illuminate\Database\Eloquent\Builder $query
       * @return \Illuminate\Database\Eloquent\Builder
       */
    public function scopeCompletedOrder(Builder $builder)
    {
        return $builder->where('status','completed');
    }
}
