<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Post;
class Tag extends Model
{
    /**
     * Get all of the posts that are assigned this tag.
     */
    public function posts()
    {
        return $this->morphedByMany(Post::class, 'taggable');
    }
}
