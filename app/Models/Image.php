<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class Image extends Model
{

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
    protected $fillable = [
        'product_id', 'name',  'size', 'location', 'format'
    ];
    /**
     * Block comment
     *
     * @param type
     * @return void
     */
    public function products()
    {
        return $this->belongsTo(Product::class);
    }
}
