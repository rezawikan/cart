<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Subdistrict;
use App\Models\Traits\CanBeDefault;

class Address extends Model
{
    use CanBeDefault;

    protected $fillable = [
      'name',
      'phone',
      'address_1',
      'subdistrict_id',
      'default'
    ];

    /**
     * Block comment
     *
     * @param type
     * @return void
     */
    public function setDefaultAttribute($value)
    {
        $this->attributes['default'] = ($value === 'true' ? true : false);
    }

    /**
     * Block comment
     *
     * @param type
     * @return void
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Block comment
     *
     * @param type
     * @return void
     */
    public function subdistrict()
    {
        return $this->hasOne(Subdistrict::class, 'id', 'subdistrict_id');
    }
}
