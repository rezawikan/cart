<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductEditResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
      return array_merge(parent::toArray($request), [
        'images' => $this->images,
        'variations' => $variations = ProductVariationEditResource::collection($this->variations->groupBy('type.name'))
      ]);
    }
}
