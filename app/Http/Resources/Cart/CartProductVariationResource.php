<?php

namespace App\Http\Resources\Cart;

use App\Http\Resources\ProductVariationResource;
use App\Http\Resources\ProductIndexResource;
use App\Pattern\Cart\Money;

class CartProductVariationResource extends ProductVariationResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return array_merge(parent::toArray($request), [
          'product' => new ProductIndexResource($this->product),
          'type'    => $this->type,
          'weight' =>  $this->weight * $this->pivot->quantity,
          'quantity' => $this->pivot->quantity,
          'total'    => $this->getTotal(),
          'base_total' => $this->getBaseTotal()
        ]);
    }

    protected function getBaseTotal()
    {
        return $this->pivot->quantity * $this->base_price;
    }

    protected function getTotal()
    {
        return $this->pivot->quantity * $this->price;
    }
}
