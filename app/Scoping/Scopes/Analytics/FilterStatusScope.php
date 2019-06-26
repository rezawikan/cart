<?php

namespace App\Scoping\Scopes\Analytics;

use Illuminate\Database\Eloquent\Builder;
use App\Scoping\Contracts\Scope;

/**
 *
 */
class FilterStatusScope implements Scope
{
    public function apply(Builder $builder, $value)
    {
        return $builder->where('status', $value);
    }
}
