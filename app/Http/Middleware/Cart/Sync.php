<?php

namespace App\Http\Middleware\Cart;

use Closure;
use App\Pattern\Cart\Cart;
use App\Models\User;

class Sync
{
    protected $cart;

    public function __construct(Cart $cart)
    {
        $this->cart = $cart;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->has('user_id')) {
            $user = User::find($request->user_id);
            $cart = new Cart($user);

            $cart->sync();

            if ($cart->hasChanged()) {
              return response()->json([
                'message' => 'some items in your cart have changed. Please Review these changes before placing your order.'
              ], 409);
            }
            return $next($request);

        } else {
            $this->cart->sync();

            if ($this->cart->hasChanged()) {
              return response()->json([
                'message' => 'some items in your cart have changed. Please Review these changes before placing your order.'
              ], 409);
            }
            return $next($request);
        }
    }
}
