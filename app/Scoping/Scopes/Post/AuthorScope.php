<?php

namespace App\Scoping\Scopes\Post;

use Illuminate\Database\Eloquent\Builder;
use App\Scoping\Contracts\Scope;

/**
 *
 */
class AuthorScope implements Scope
{
    public function apply(Builder $builder, $value)
    {
        if ($value == null) {
            return $builder;
        }
        return $builder->whereHas('authors', function ($builder) use ($value) {
            $builder->where('id', $value);
        });
    }
}
