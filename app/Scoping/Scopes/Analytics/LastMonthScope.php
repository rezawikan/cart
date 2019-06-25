<?php

namespace App\Scoping\Scopes\Analytics;

use Illuminate\Database\Eloquent\Builder;
use App\Scoping\Contracts\Scope;
use Carbon\Carbon;

/**
 *
 */
class LastMonthScope implements Scope
{
    public function apply(Builder $builder, $value)
    {
        return $builder->whereMonth('created_at', '=', Carbon::now()->subMonth()->month);
    }
}
