<?php

namespace App\Http\Resources;

use App\Http\Resources\AddressResource;
use App\Http\Resources\ReturnOrderResource;
use App\Http\Resources\ShippingMethodResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ProductVariationOrderResource;

class OrderResource extends JsonResource
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
          'products'        => ProductVariationOrderResource::collection($this->whenLoaded('products')),
          'address'         => new AddressResource($this->whenLoaded('address')),
          'shipping_method' => new ShippingMethodResource($this->whenLoaded('shippingMethod')),
          'payment_method'  => $this->paymentMethod->type,
          'revenue'         => $this->revenue(),
          'quantity'        => $this->products->sum(function($product){
              return $product->pivot->quantity;
          }),
          'returns'         => new ReturnOrderResource($this->whenLoaded('returns'))
        ];
    }
}
