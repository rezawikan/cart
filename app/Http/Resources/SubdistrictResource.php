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
          'province' => $this->city->province->name,
          'city' => $this->city->name,
          'subdistrict' => $this->name
        ];
    }
}
