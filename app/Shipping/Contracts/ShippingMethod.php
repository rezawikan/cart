<?php

namespace App\Shipping\Contracts;

abstract class ShippingMethod
{
     // 
     // public function getProvince(array $data);
     //
     // public function getCity(array $data);
     //
     // public function getSubdistrict(array $data);

    abstract public function getOrigin(array $data);

    abstract public function getDestination(array $data);

    abstract public function getCost(array $data);
}
