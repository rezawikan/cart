<?php

namespace App\Scoping\Scopes\Products;

use Illuminate\Database\Eloquent\Builder;
use App\Scoping\Contracts\Scope;

/**
 *
 */
class NameScope implements Scope
{
    public function apply(Builder $builder, $value)
    {
        return $builder->whereRaw("UPPER(name) LIKE '%". strtoupper($value)."%'");
    }
}
