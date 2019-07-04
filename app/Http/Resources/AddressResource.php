<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\SubdistrictResource;

class AddressResource extends JsonResource
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
          'name' => $this->name,
          'address_1' => $this->address_1,
          'subdistrict' => new SubdistrictResource($this->subdistrict),
          'phone' => $this->phone,
          'default' => (bool) $this->default
        ];
    }
}
