<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Author;
use App\Models\Tag;
use App\Models\Traits\CanBeScoped;
use App\Models\Traits\LatestOrder;
use App\Models\Traits\IsLive;
use App\Scoping\Scopes\AuthorScope;
use App\Scoping\Scopes\TagScope;

class Post extends Model
{
    use CanBeScoped,LatestOrder,IsLive;
    //
    /**
     * Block comment
     *
     * @param type
     * @return void
     */
    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    /**
    * Get all of the tags for the post.
    */
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    //
    /**
     * Block comment
     *
     * @param type
     * @return void
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function scopes()
    {
        return [
          'author' => new AuthorScope(),
          'tag' => new TagScope()
        ];
    }
}
