<?php

namespace App\Http\Controllers\Stock;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\LiveStockResource;

class LiveStockController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth:api']);
    }

    /**
    * Show the profile for the given user.
    *
    * @param  int  $id
    * @return View
    */
   public function __invoke(Request $request)
   {

        $stock = DB::table('product_variation_stock_view')
        ->join('products','products.id','=','product_variation_stock_view.product_id')
        ->join('product_variations','product_variations.id','=','product_variation_stock_view.product_variation_id')
        ->join('product_variation_types','product_variation_types.id','=','product_variations.product_variation_type_id')
        ->select('products.name','product_variation_stock_view.stock','product_variations.name as sub_type','product_variation_types.name as type')->orderBy('products.name','ASC');

        $stocks = $this->ScopeRequest($request, $stock)->paginate(20)->appends($request->except('page'));

        return LiveStockResource::collection($stocks);
   }

   /**
   * Show the profile for the given user.
   *
   * @param  int  $id
   * @return View
   */
   protected function ScopeRequest(Request $request, $query) {
     if ($request->name) {
          return $query->where('products.name','LIKE', '%'.$request->name.'%')->orWhere('product_variation_types.name','LIKE','%'.$request->name.'%');
     }
     return $query;
   }
}
