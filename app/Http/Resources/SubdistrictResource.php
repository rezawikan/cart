<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SubdistrictResource extends JsonResource
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
          'city_id' => $this->city_id,
          'city' => $this->city->name,
          'province_id' => $this->city->province->id,
          'province' => $this->city->province->name,
          'subdistrict' => $this->name
        ];
    }
}
