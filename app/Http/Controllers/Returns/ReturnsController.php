<?php

namespace App\Http\Controllers\Returns;

use App\Models\Returns;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Events\ReturnCreate\ReturnCreate;
use App\Events\ReturnUpdate\ReturnUpdate;
use App\Http\Resources\ReturnsResource;
use App\Http\Resources\ReturnsEditResource;
use App\Scoping\Scopes\Returns\OrderIdScope;
use App\Pattern\ReturnProduct\HandleReturnProduct;

class ReturnsController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth:api']);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected function scopes()
    {
        return [
          'order_id'    => new OrderIdScope(),
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $returns = Returns::LatestOrder()
        ->with([
          'variation',
          'variation.product',
          'variation.type'
        ])
        ->withScopes($this->scopes())
        ->orderBy('order_id')
        ->paginate(12);

        return ReturnsResource::collection($returns);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, HandleReturnProduct $handle)
    {
        $handle->setRequest($request);
        $order    = $handle->findOrder();
        $products = $handle->convertProduct();
        $returns  = $handle->convertReturn();
        //
        $order->products()->sync($products);
        //
        event(new ReturnCreate($order, $returns));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Returns $returns)
    {
        $returns->load(['order.products']);
        return new ReturnsEditResource($returns);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Returns $returns)
    {
      event(new ReturnUpdate($request, $returns));
      $returns->update($request->only(['quantity','info','status','discount']));
      //

      // if ($request->quantity > $returns->quantity) {
      //
      //     return 'masuk';

          // $returns->order->products()->updateExistingPivot($request->product_variation_id, [
          //   'quantity' => $request->quantity - ($returns->quantity+1),
          //   'status' => $request->status
          // ]);

          // $returns->update($request->only(['quantity','info','status']));
          //
          //
          // $returns->order()->update([
          //   'base_subtotal' => $returns->order->newBaseSubTotal(),
          //   'subtotal' => $returns->order->newSubTotal(),
          //   'total' =>   $returns->order->newTotal()
          // ]);


      // } elseif ($request->quantity < $returns->quantity) {
      //    $variantOrder = $returns->order->products->where('pivot.product_variation_id', $request->product_variation_id)->first();
      //    return ($variantOrder->pivot->quantity + $returns->quantity) - $request->quantity;
      //    return  ;
          // $returns->order->products()->updateExistingPivot($variantOrder->id, [
          //   'quantity' => $returns->quantity - $request->quantity,
          //   'status' => $request->status
          // ]);

          // $returns->update($request->only(['quantity','info','status']));
          //
          // $returns->order()->update([
          //   'base_subtotal' => $returns->order->newBaseSubTotal(),
          //   'subtotal' => $returns->order->newSubTotal(),
          //   'total' =>   $returns->order->newTotal()
          // ]);

      // } else {
      //   return 'takada';
      //     // $returns->update($request->only(['quantity','info','status']));
      // }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
