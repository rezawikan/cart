<?php

namespace App\Http\Controllers\Analytics;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Timeable\CountAnalyticsResource;
use App\Http\Resources\Timeable\RevenueAnalyticsResource;
use App\Scoping\Scopes\Analytics\FilterPriodScope;
use App\Scoping\Scopes\Analytics\FilterStatusScope;

class AnalyticsController extends Controller
{
    public function __construct()
    {
        // $this->middleware(['auth:api']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected function scopes()
    {
        return [
          'period'  => new FilterPriodScope(),
          'status'   => new FilterStatusScope()
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function countAnalytics(Request $request, $period)
    {
        $orders  = Order::LatestOrder('ASC')->withScopes($this->scopes())->get()->groupBy($period);

        if ($orders->isEmpty()) {
            return new CountAnalyticsResource([]);
        }

        $numbers = $orders->mapToGroups(function ($items, $key) {
          return [
            'numbers' => count($items)
          ];
        });

        return new CountAnalyticsResource($numbers->merge(['status' => $orders->keys()]));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function sumRevenueAnalytics(Request $request, $period)
    {
        $orders  = Order::LatestOrder('ASC')->withScopes($this->scopes())->get()->groupBy($period);

        if ($orders->isEmpty()) {
            return new RevenueAnalyticsResource([]);
        }

        $numbers = $orders->mapToGroups(function ($items, $key) {
          return [
            'revenue' => $items->sum(function($item){
              return $item->revenue();
            })
          ];
        });

        return new RevenueAnalyticsResource($numbers->merge(['status' => $orders->keys()]));
    }
}
