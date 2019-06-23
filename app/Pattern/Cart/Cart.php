<?php

namespace App\Pattern\Cart;

use App\Pattern\Cart\ConversionWeight;
use App\Models\User;
use App\Models\ShippingMethod;

class Cart
{
    public $user;

    protected $changed = false;

    protected $shipping;
    protected $discount;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function products()
    {
        return $this->user->cart;
    }

    public function add($products)
    {
        $this->user->cart()->syncWithoutDetaching(
            $this->getStorePayload($products)
        );
    }

    public function withShipping($shippingId)
    {
        $this->shipping = ShippingMethod::find($shippingId);

        if ($this->shipping) {
            $this->shipping->price = $this->shipping->price * $this->totalWeight();
        }

        return $this;
    }

    public function withDiscount($discount)
    {
        if ($discount) {
            $this->discount = $discount;
        }

        return $this;
    }

    public function update($productID, $quantity)
    {
        $this->user->cart()->updateExistingPivot($productID, [
          'quantity' => $quantity
        ]);
    }

    public function hasChanged()
    {
        return $this->changed;
    }

    public function delete($productID)
    {
        $this->user->cart()->detach([$productID]);
    }

    public function empty()
    {
        $this->user->cart()->detach();
    }

    public function isEmpty()
    {
        if (count($this->user->cart) != 0) {
            $map = collect($this->user->cart)->map(function ($cart) {
                return [
                  $cart->pivot->quantity <= 0
                ];
            });

            return in_array(true, array_flatten($map->toArray(), true));
        }

        return true;
    }

    public function sync()
    {
        $this->user->fresh()->cart->each(function ($product) {
            $quantity = $product->minStock($product->pivot->quantity);

            if ($quantity != $product->pivot->quantity) {
                $this->changed = true;
            }

            $product->pivot->update([
            'quantity' => $quantity
          ]);
        });
    }

    public function subTotal()
    {
        $subtotal = $this->user->cart->sum(function ($product) {
            return $product->price * $product->pivot->quantity;
        });

        return $subtotal;
    }

    public function baseSubTotal()
    {
        $subtotal = $this->user->cart->sum(function ($product) {
            return $product->base_price * $product->pivot->quantity;
        });

        return $subtotal;
    }

    public function totalWeight()
    {
        $subtotal = $this->user->cart->sum(function ($product) {
            return $product->weight * $product->pivot->quantity;
        });

        return (new ConversionWeight($subtotal))->result();
    }


    public function total()
    {
        if ($this->shipping) {
            return $this->shipping->price + $this->subtotal() - $this->discount;
        }
        return $this->subtotal() - $this->discount;
    }

    protected function getStorePayload($products)
    {
        return collect($products)->keyBy('id')->map(function ($product) {
            return [
              'quantity' => $product['quantity'] + $this->getCurrentQuantity($product['id'])
            ];
        })->toArray();
    }

    protected function getCurrentQuantity($productID)
    {
        if ($product = $this->user->cart->where('id', $productID)->first()) {
            return $product->pivot->quantity;
        }

        return 0;
    }
}
