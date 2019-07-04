<?php

namespace App\Scoping\Scopes\Returns;

use Illuminate\Database\Eloquent\Builder;
use App\Scoping\Contracts\Scope;

/**
 *
 */
class OrderIdScope implements Scope
{
    public function apply(Builder $builder, $value)
    {
        return $builder->where('order_id', $value);
    }
}
