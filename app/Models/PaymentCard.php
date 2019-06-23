<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentCard extends Model
{
    // use CanBeDefault;

    protected $fillable = [
      'card_type',
      'last_four',
      'provider_id',
      'default'
    ];

    public function setDefaultAttribute($value)
    {
        $this->attributes['default'] = ($value === 'true' ? true : false);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
