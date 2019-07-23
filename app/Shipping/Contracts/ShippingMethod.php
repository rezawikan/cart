<?php

namespace App\Shipping\Contracts;

abstract class ShippingMethod
{

     abstract public function getProvince(array $data);

     abstract public function getCity(array $data);

     abstract public function getSubdistrict(array $data);

    abstract public function getCost(array $data);
}
