<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AnalyticsOrderResource extends JsonResource
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
          'id'            => $this->id,
          'status'        => $this->status,
          'date'          => $this->created_at->toDateTimeString(),
          'month'         => $this->created_at->month,
          'week'          => $this->created_at->week,
          'day'           => $this->created_at->day,
          'subtotal'      => $this->subtotal,
          'base_subtotal' => $this->base_subtotal,
          'total'         => $this->total(),
          'revenue'       => $this->revenue()
        ];
    }
}
