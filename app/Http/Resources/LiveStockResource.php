<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LiveStockResource extends JsonResource
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
        'name'      => $this->name,
        'stock'     => $this->stock,
        'sub_type'  => $this->sub_type,
        'type'      => $this->type
      ];
    }
}
