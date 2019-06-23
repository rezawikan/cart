<?php

namespace App\Http\Controllers\Cart;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Cart\CartStoreRequest;
use App\Http\Requests\Cart\CartUpdateRequest;
use App\Pattern\Cart\Cart;
use App\Models\ProductVariation;
use App\Http\Resources\Cart\CartResource;
use App\Models\User;

class PublicCartController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api']);
    }

    public function index(Request $request)
    {
        $user = User::find($request->user_id);
        $cart = new Cart($user);

        $cart->sync();

        $user->load(['cart.product','cart.product.variations.stock','cart.stock','cart.type']);

        return (new CartResource($user))->additional([
          'meta' => $this->meta($request)
        ]);
    }

    protected function meta(Request $request)
    {
      $user = User::find($request->user_id);
      $cart = new Cart($user);

      return [
        'empty' => $cart->isEmpty(),
        'weight' => $cart->totalWeight(),
        'subtotal' => $cart->subTotal(),
        'total' => $cart->withShipping($request->shipping_method_id)->withDiscount($request->discount)->total(),
        'changed' => $cart->hasChanged()
      ];
    }

    public function store(CartStoreRequest $request)
    {
        $user = User::find($request->user_id);
        $cart = new Cart($user);
        $cart->add($request->products);
    }

    public function update(ProductVariation $productVariation, CartUpdateRequest $request)
    {
        $user = User::find($request->user_id);

        $cart = new Cart($user);
        $cart->update($productVariation->id, $request->quantity);
    }

    public function destroy(Request $request, ProductVariation $productVariation)
    {
        $user = User::find($request->user_id);
        $cart = new Cart($user);

        $cart->delete($productVariation->id);
    }
}
