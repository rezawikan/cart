<?php

namespace App\Scoping\Scopes\Variations;

use Illuminate\Database\Eloquent\Builder;
use App\Scoping\Contracts\Scope;
use App\Models\Category;

/**
 *
 */
class NameScope implements Scope
{
    public function apply(Builder $builder, $value)
    {
        return $builder->where('name','like','%'.$value.'%')
        ->orWhereHas('product', function($builder) use ($value) {
          $builder->where('name','like','%'.$value.'%');
        });
    }
}
