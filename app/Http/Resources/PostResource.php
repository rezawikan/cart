<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\AuthorResource;
use App\Http\Resources\TagResource;

class PostResource extends JsonResource
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
          'body' => $this->body,
          'image' => $this->image,
          'created_at' => $this->created_at->diffForHumans(),
          'author' => new AuthorResource($this->author),
          'tags'=> TagResource::collection($this->tags)
        ];
    }
}
