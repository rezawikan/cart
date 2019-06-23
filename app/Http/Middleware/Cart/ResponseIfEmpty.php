<?php

namespace App\Http\Middleware\Cart;

use Closure;
use App\Pattern\Cart\Cart;
use App\Models\User;

class ResponseIfEmpty
{
    protected $cart;

    public function __construct(Cart $cart)
    {
        $this->cart =  $cart;
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

            if ($cart->isEmpty()) {
              return response()->json([
                'message' => 'Cart is empty'
              ], 400);
            }
            return $next($request);

        } else {
          if ($this->cart->isEmpty()) {
            return response()->json([
              'message' => 'Cart is empty'
            ], 400);
          }
          return $next($request);
        }
    }
}
