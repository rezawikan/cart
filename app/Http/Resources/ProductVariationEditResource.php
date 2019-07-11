<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ProductVariationEditResource;
use Illuminate\Support\Collection;

class ProductVariationEditResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
      if ($this->resource instanceof Collection) {
          return ProductVariationEditResource::collection($this->resource);
      }

      return [
        'id'    => $this->id,
        'name'  => $this->name,
        'price' => $this->price,
        'base_price' => $this->base_price,
        'stock_count' => (int) $this->stockCount(),
        'type'  => [
          'id' => $this->type->id,
          'name' => $this->type->name,
        ],
        'product' =>  [
          'id' => $this->product->id,
          'name' => $this->product->name
        ],
        'weight'  => $this->weight,
        'deleteable'  => $this->deleteable(),
      ];
    }
}
