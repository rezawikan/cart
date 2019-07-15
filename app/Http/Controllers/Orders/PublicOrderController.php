<?php

namespace App\Http\Controllers\Orders;

use App\Models\User;
use App\Models\Order;
use App\Pattern\Cart\Cart;
use Illuminate\Http\Request;
use App\Payment\PaymentHandler;
use App\Events\Orders\OrderCreated;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Scoping\Scopes\Orders\IDScope;
use App\Http\Resources\OrderIndexResource;
use  App\Scoping\Scopes\Orders\StatusScope;
use App\Http\Requests\Order\OrderStoreRequest;
use App\Http\Requests\Addresses\AddressStoreRequest;

class PublicOrderController extends Controller
{
    protected $cart;
    protected $method;

    public function __construct()
    {
        // $this->middleware(['auth:api']);
        $this->middleware(['cart.isenotempty','cart.sync'])->only('store');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected function scopes()
    {
        return [
          'id'      => new IDScope(),
          'status'  => new StatusScope()
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $orders = Order::LatestOrder()
        ->withScopes($this->scopes())
        ->with([
          'user',
          'products',
          'products.stock',
          'products.type',
          'products.product.variations.stock',
          'address.subdistrict',
          'shippingMethod',
          'paymentMethod',
          'returns'
        ])
        ->paginate(12);

        return OrderIndexResource::collection($orders);
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
    public function store(Request $request)
    {
        $user  = User::find($request->user_id);
        $cart  = new Cart($user);
        $order = $this->createOrder($request, $cart);

        $order->products()->sync($cart->products()->forSyncing());
        $order->load(['products']);

        event(new OrderCreated($order));

        return new OrderIndexResource($order);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function createOrder(Request $request, $cart)
    {
        $total = $cart->withShipping($request->shipping_method_id)->withDiscount($request->discount)->total();
        return User::find($request->user_id)->orders()->create(
          array_merge(
            $request->only(['address_id','shipping_method_id','payment_method_id','discount','created_at']),
            ['total' => $total, 'subtotal' => $cart->subTotal(), 'base_subtotal' => $cart->baseSubTotal() - $request->discount ]
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function createPayment(Request $request, Cart $cart)
    {
        (new Payment)->createInvoice();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        $order->load([
          'products',
          'products.stock',
          'products.type',
          'products.product.variations.stock',
          'address.subdistrict',
          'shippingMethod',
          'paymentMethod',
          'returns'
        ]);

        return new OrderResource($order);
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
    public function update(Request $request, $id)
    {
      //
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
