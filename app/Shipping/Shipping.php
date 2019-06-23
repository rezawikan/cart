<?php

namespace App\Shipping;

use App\Shipping\Types\International;
use App\Shipping\Types\National;

/**
 *
 */
class Shipping
{
    public $shipping;

    protected $types = [
      'international' => International::class,
      'national'  => National::class
    ];

    public function __construct($type)
    {
        $this->shipping = $this->resolveType($type) ;
    }

    protected function resolveType($type)
    {
        return new $this->types[$type];
    }
}
