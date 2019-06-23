<?php

namespace App\Models\Traits;


use Illuminate\Database\Eloquent\Builder;

trait HasChildren
{

    /**
     * Block comment
     *
     * @param type
     * @return void
     */
    public function scopeParents(Builder $builder)
    {
        $builder->whereNull('parent_id');
    }

}
