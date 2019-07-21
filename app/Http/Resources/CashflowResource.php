<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CashflowResource extends JsonResource
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
          'total'       => $this->total,
          'type'        => $this->type,
          'amount'      => $this->amount,
          'info'        => $this->info,
          'created_at'  => $this->created_at->toDateTimeString()
        ];
    }
}
