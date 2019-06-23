<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\AuthorResource;

class PostIndexResource extends JsonResource
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
        'title' => $this->title,
        'slug' => $this->slug,
        'summary' => $this->summary,
        'image' => $this->image,
        'created_at' => $this->created_at->diffForHumans(),
        'author' => new AuthorResource($this->author)
      ];
    }
}
