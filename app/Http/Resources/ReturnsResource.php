<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReturnsResource extends JsonResource
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
          'order_id'        => $this->order_id,
          'variation_name'  => $this->variation->name,
          'product_name'    => $this->variation->product->name,
          'product_type'    => $this->variation->type->name,
          'quantity'        => $this->quantity,
          'status'          => $this->status,
          'info'            => $this->info
        ];
    }
}
