<?php

namespace App\Http\Resources;

use Illuminate\Support\Collection;
use Illuminate\Http\Resources\Json\JsonResource;

class ReturnOrderResource extends JsonResource
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
            return ReturnOrderResource::collection($this->resource);
        }

        return [
          'variation_name' => $this->variation->name,
          'product_name'   => $this->variation->product->name,
          'type_name'      => $this->variation->type->name,
          'original_price' => $this->original_price,
          'quantity'       => $this->quantity,
          'status'         => $this->status,
          'info'           => $this->info,
        ];
    }
}
