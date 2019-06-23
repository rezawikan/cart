<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;

trait CanBeDefault
{
    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if ($model->default) {
                $model->newQuery()->where('user_id', $model->user->id)->update([
                  'default' => false
                ]);
            }
        });
    }
}
