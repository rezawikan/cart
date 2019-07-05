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
          'subdistrict_id' => $this->subdistricts->first()->id,
          'subdistrict' => $this->subdistricts->first()->name,
          'city' => $this->subdistricts->first()->city->name,
          'province' => $this->subdistricts->first()->city->province->name,
          'id'     => $this->id,
          'code'  => $this->code,
          'type'  => $this->type,
          'courier' => $this->courier,
          'price' => $this->price,
          'estimation'  => $this->estimation
        ];
    }
}
