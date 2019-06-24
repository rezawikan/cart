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
        return $builder->whereRaw("UPPER(name) LIKE '%". strtoupper($value)."%'")
        ->orWhereHas('product', function($builder) use ($value) {
          $builder->whereRaw("UPPER(name) LIKE '%". strtoupper($value)."%'");
        })->orWhereHas('type', function($builder) use ($value) {
          $builder->whereRaw("UPPER(name) LIKE '%". strtoupper($value)."%'");
        });
    }
}
