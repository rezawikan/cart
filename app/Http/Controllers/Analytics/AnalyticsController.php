<?php

namespace App\Http\Controllers\Analytics;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\AnalyticsOrderResource;
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
    public function analytics(Request $request)
    {
        $orders = Order::withScopes($this->scopes())->get();

        return AnalyticsOrderResource::collection($orders);
    }
}
