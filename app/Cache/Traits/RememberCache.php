<?php

namespace App\Cache\Traits;

trait RememberCache
{
      /**
       * Scope a query to only include popular users.
       *
       * @param \Illuminate\Database\Eloquent\Builder $query
       * @return \Illuminate\Database\Eloquent\Builder
       */
    public function setCacheKey($array)
    {
      $count  = count($array);
      $value = [];
      for ($i=0; $i < $count; $i++) {
               $value[]= '%s';
            }

      $sign = implode(".",$value);

      return md5(vsprintf($sign, $array));

    }
}
