<?php

namespace App\Scoping\Scopes\Products;

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
        return $builder->where('name','like','%'.$value.'%');
    }
}
