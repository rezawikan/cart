<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\CategoryResource;

class CategoryResource extends JsonResource
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
          'name'     => $this->name,
          'slug'     => $this->slug,
          'children' => CategoryResource::collection($this->whenLoaded('childrenRecursive'))
        ];
    }
}
