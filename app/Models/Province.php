<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\City;
use App\Models\Subdistrict;
use App\Models\Traits\CanBeScoped;

class Province extends Model
{
    use CanBeScoped;
    /**
    * Get all of the posts for the country.
    */
    public function subdistricts()
    {
        return $this->hasManyThrough(Subdistrict::class, City::class);
    }

    /**
    * Get the comments for the blog post.
    */
    public function cities()
    {
        return $this->hasMany(City::class);
    }
}
