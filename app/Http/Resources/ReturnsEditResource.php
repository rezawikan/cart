<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\OrderIndexResource;

class ReturnsEditResource extends JsonResource
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
          'id'                   => $this->id,
          'order_id'             => $this->order_id,
          'product_variation_id' => $this->product_variation_id,
          'original_price'       => $this->original_price,
          'variation_name'       => $this->variation->name,
          'product_name'         => $this->variation->product->name,
          'product_type'         => $this->variation->type->name,
          'quantity'             => $this->quantity,
          'discount'             => $this->discount,
          'status'               => $this->status,
          'info'                 => $this->info,
          'order'                => new OrderIndexResource($this->order)
        ];
    }
}
