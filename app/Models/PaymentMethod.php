<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\CanBeDefault;

class PaymentMethod extends Model
{
    protected $fillable = [
      'type'
    ];
}
