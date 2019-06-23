<?php

namespace App\Pattern\Cart\Payments;

use App\Models\User;
/**
 *
 */
interface Gateway
{
    public function withUser(User $user);
    public function createCustomer();
}
