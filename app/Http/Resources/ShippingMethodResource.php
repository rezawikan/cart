<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Pattern\Cart\Cart;
use App\Models\Address;

class ShippingMethodResource extends JsonResource
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
          'id' => $this->id,
          'courier' => $this->courier,
          'type' => $this->type,
          'code' => $this->code,
          'price' => $this->price,
          'estimation' => $this->estimation
        ];
    }
}
