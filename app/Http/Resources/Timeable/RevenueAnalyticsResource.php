<?php

namespace App\Http\Resources\Timeable;

use Illuminate\Http\Resources\Json\JsonResource;

class RevenueAnalyticsResource extends JsonResource
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
          'revenue' => $this->resource['revenue'],
          'status'  => $this->resource['status']
        ];
    }
}
