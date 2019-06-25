<?php

namespace App\Http\Controllers\Analytics;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Scoping\Scopes\Analytics\LastMonthScope;

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
          // 'last_week'  => new CategoryScope(),
          'last_month' => new LastMonthScope(),
          // 'last_year' => new PopularScope()
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function revenue(Request $request)
    {
         $orders = Order::CompletedOrder()->withScopes($this->scopes())->get();

        return OrderResource::collection($orders);
    }
}
