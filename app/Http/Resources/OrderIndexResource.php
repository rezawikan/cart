<?php

namespace App\Http\Resources;

use App\Http\Resources\AddressResource;
use App\Http\Resources\ReturnOrderResource;
use App\Http\Resources\ShippingMethodResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ProductVariationOrderResource;

class OrderIndexResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
          'id'              => $this->id,
          'status'          => $this->status,
          'created_at'      => $this->created_at->toDateTimeString(),
          'subtotal'        => $this->subtotal,
          'base_subtotal'   => $this->base_subtotal,
          'discount'        => $this->discount,
          'total'           => $this->total,
          'shipping_price'  => $this->shippingPrice(),
          'products'        => ProductVariationOrderResource::collection($this->whenLoaded('products')),
          'quantity'        => $this->products->sum(function($product){
              return $product->pivot->quantity;
          })
        ];
    }
}
