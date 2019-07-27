<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ProductIndexResource;
use App\Http\Resources\ProductVariationResource;
use Illuminate\Support\Collection;

class ProductVariationResource extends JsonResource
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
            return ProductVariationResource::collection($this->resource);
        }

        return [
          'id'      => $this->id,
          'product' => new ProductIndexResource($this->product),
          'type'    => new ProductVariationTypeResource($this->type),
          'name'    => $this->name,
          'price'   => $this->price,
          'base_price' => $this->base_price,
          'weight'  => $this->weight,
          'stock'   => $this->stockCount()
        ];

      }

}
