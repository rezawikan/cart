<?php

namespace App\Scoping\Scopes\Orders;

use Illuminate\Database\Eloquent\Builder;
use App\Scoping\Contracts\Scope;

/**
 *
 */
class IDScope implements Scope
{
    public function apply(Builder $builder, $value)
    {
        return $builder->where('id',$value);
    }
}
