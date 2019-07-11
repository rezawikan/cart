<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductIndexResource extends JsonResource
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
          'id'          => $this->id,
          'name'        => $this->name,
          'slug'        => $this->slug,
          'description' => $this->description,
          'weight'      => $this->custom_weight,
          'images'      => $this->images,
          'price'       => $this->custom_price,
          'base_price'  => $this->base_price,
          'stock_count' => $this->stockCount(),
          'in_stock'    => $this->inStock(),
          'price_varies' => $this->varies()
        ];
    }
}
