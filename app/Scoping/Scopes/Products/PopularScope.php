<?php

namespace App\Scoping\Scopes\Products;

use Illuminate\Database\Eloquent\Builder;
use App\Scoping\Contracts\Scope;
use Illuminate\Support\Facades\DB;

/**
 *
 */
class PopularScope implements Scope
{
    public function apply(Builder $builder, $value)
    {
        $popular = DB::select("SELECT product_variation_id, SUM(CASE WHEN product_variation_order.status > @'accepted' THEN product_variation_order.quantity ELSE 0 END ) AS quantity FROM product_variation_order GROUP BY product_variation_id ORDER BY quantity {$value} LIMIT 9");

        $filter = array_map(function($data){
          return $data->product_variation_id;
        }, $popular);

        return $builder->whereHas('variations', function ($builder) use ($filter) {
            $builder->whereIn('id', $filter);
        });
    }
}
