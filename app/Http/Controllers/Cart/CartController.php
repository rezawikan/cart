<?php

namespace App\Http\Controllers\Cart;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Cart\CartStoreRequest;
use App\Http\Requests\Cart\CartUpdateRequest;
use App\Pattern\Cart\Cart;
use App\Models\ProductVariation;
use App\Http\Resources\Cart\CartResource;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api']);
    }

    public function index(Request $request, Cart $cart)
    {
        $cart->sync();

        $request->user()->load(['cart.product','cart.product.variations.stock','cart.stock','cart.type']);

        return (new CartResource($request->user()))->additional([
          'meta' => $this->meta($cart, $request)
        ]);
    }

    protected function meta(Cart $cart, Request $request)
    {
      return [
        'empty' => $cart->isEmpty(),
        'weight' => $cart->totalWeight(),
        'subtotal' => $cart->subTotal(),
        'total' => $cart->withShipping($request->shipping_method_id)->total(),
        'changed' => $cart->hasChanged()
      ];
    }

    public function store(CartStoreRequest $request, Cart $cart)
    {
        $cart->add($request->products);
    }

    public function update(ProductVariation $productVariation, CartUpdateRequest $request, Cart $cart)
    {
        $cart->update($productVariation->id, $request->quantity);
    }

    public function destroy(ProductVariation $productVariation, Cart $cart)
    {
        $cart->delete($productVariation->id);
    }
}
