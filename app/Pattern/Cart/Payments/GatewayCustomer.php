<?php

namespace App\Pattern\Cart\Payments;

use App\Models\User;
use App\Models\PaymentMethod;
/**
 *
 */
interface GatewayCustomer
{
    public function charge(PaymentMethod $card, $amount);
    public function addCard($token);
    public function id();
}
