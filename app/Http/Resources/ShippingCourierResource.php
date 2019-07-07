<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ShippingCourierResource extends JsonResource
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
          'subdistrict_id'    => $this->id,
          'subdistrict'       => $this->name,
          'city'              => $this->city->name,
          'province'          => $this->city->province->name,
          'numbers'           => count($this->shippingMethods),
          'shipping_methods'  => $this->shippingMethods
        ];
    }
}
