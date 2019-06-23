<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Subdistrict;
use App\Models\Province;
use App\Models\Traits\CanBeScoped;

class City extends Model
{
    use CanBeScoped;
    
    protected $fillable = [
      'name',
      'province_id'
    ];

    /**
    * Get the comments for the blog post.
    */
    public function subdistricts()
    {
        return $this->hasMany(Subdistrict::class);
    }

    /**
    * Get the comments for the blog post.
    */
    public function province()
    {
        return $this->belongsTo(Province::class);
    }
}
