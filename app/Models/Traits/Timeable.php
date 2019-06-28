<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;

trait Timeable
{
      /**
    * Get the user's full name.
    *
    * @return string
    */
    public function getDayAttribute()
    {
      return $this->created_at->format('M-d');
    }

      /**
    * Get the user's full name.
    *
    * @return string
    */
    public function getMonthAttribute()
    {
      return $this->created_at->format('M');
    }

      /**
    * Get the user's full name.
    *
    * @return string
    */
    public function getYearAttribute()
    {
      return $this->created_at->format('Y');
    }

      /**
    * Get the user's full name.
    *
    * @return string
    */
    public function getWeekAttribute()
    {
      return $this->created_at->week;
    }
}
