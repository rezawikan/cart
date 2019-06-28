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
            Carbon::today()->subDays($value),
            Carbon::today()
          ]);
      }

      switch ($value) {
        case 'this_week':
          return $builder->whereBetween('created_at', [
            Carbon::today()->startOfWeek(),
            Carbon::today()->endOfWeek()
          ]);
          break;

        case 'this_month':
          return $builder->whereMonth('created_at', Carbon::today()->month);
          break;

        case 'this_year':
          return $builder->whereYear('created_at',Carbon::today()->year);
          break;

        case 'last_week':
          return $builder->whereBetween('created_at', [
            Carbon::today()->subWeek()->startOfWeek(),
            Carbon::today()->subWeek()->endOfWeek()
          ]);
          break;

        case 'last_month':
          return $builder->whereMonth('created_at', Carbon::today()->subMonth()->month);
          break;

        case 'last_year':
          return $builder->whereYear('created_at',Carbon::today()->subYear()->year);
          break;

        case 'back_year':
          return $builder->whereBetween('created_at', [
            Carbon::today()->month,
            Carbon::today()->subMonths(12)
          ]);
          break;

        default:
          return $builder;
          break;
      }

    }
}
