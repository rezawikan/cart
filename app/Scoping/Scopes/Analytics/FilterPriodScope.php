<?php

namespace App\Scoping\Scopes\Analytics;

use Illuminate\Database\Eloquent\Builder;
use App\Scoping\Contracts\Scope;
use Carbon\Carbon;

/**
 *
 */
class FilterPriodScope implements Scope
{
    public function apply(Builder $builder, $value)
    {

      if (is_numeric($value)) {
          return $builder->whereBetween('created_at', [
            Carbon::now()->subDays($value),
            Carbon::now()
          ]);
      }

      switch ($value) {
        case 'this_week':
          return $builder->whereBetween('created_at', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek()
          ]);
          break;

        case 'this_month':
          return $builder->whereMonth('created_at', Carbon::now()->month);
          break;

        case 'this_year':
          return $builder->whereYear('created_at',Carbon::now()->year);
          break;

        case 'last_week':
          return $builder->whereBetween('created_at', [
            Carbon::now()->subWeek()->startOfWeek(),
            Carbon::now()->subWeek()->endOfWeek()
          ]);
          break;

        case 'last_month':
          return $builder->whereMonth('created_at', Carbon::now()->subMonth()->month);
          break;

        case 'last_year':
          return $builder->whereYear('created_at',Carbon::now()->subYear()->year);
          break;

        default:
          return $builder;
          break;
      }

    }
}
