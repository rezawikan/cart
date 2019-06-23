<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Post;

class Author extends Model
{

  /**
   * Block comment
   *
   * @param type
   * @return void
   */
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }
    //
    /**
     * Block comment
     *
     * @param type
     * @return void
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
