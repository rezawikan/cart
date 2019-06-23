<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Traits\HasChildren;
use App\Models\Traits\IsOrderable;
use App\Models\Category;
use App\Models\Product;

class Category extends Model
{
    use HasChildren, IsOrderable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'name', 'slug',  'order'
  ];


    /**
     * Block comment
     *
     * @param type
     * @return void
     */
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }

    // recursive, loads all descendants
    public function childrenRecursive()
    {
        return $this->children()->with('childrenRecursive');
    }

    /**
     * Block comment
     *
     * @param type
     * @return void
     */
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
