<?php

namespace App\Http\Resources\Timeable;

use Illuminate\Http\Resources\Json\JsonResource;

class CountAnalyticsResource extends JsonResource
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
          'numbers' => $this->resource['numbers'],
          'status'  => $this->resource['status']
        ];
    }
}
