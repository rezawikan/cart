<?php

namespace App\Scoping\Scopes\Products;

use Illuminate\Database\Eloquent\Builder;
use App\Scoping\Contracts\Scope;

/**
 *
 */
class StatusScope implements Scope
{
    public function apply(Builder $builder, $value)
    {
        switch ($value) {
          case 'draft':
            return $builder->where('status', false);
            break;

          default:
            return $builder->where('status', true);
            break;
        }

    }
}
