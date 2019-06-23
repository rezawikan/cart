<?php

namespace App\Pattern\Cart\Payments\Gateways;

use App\Pattern\Cart\Payments\Gateway;
use App\Pattern\Cart\Payments\Gateways\StripeGatewayCustomer;
use App\Models\User;
use Stripe\Customer as StripeCustomer;

/**
 *
 */
class StripeGateway implements Gateway
{
    protected $user;

    public function withUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

    public function createCustomer()
    {

        if ($this->user->gateway_customer_id) {
            return $this->getCustomer();
        }

        $customer = new StripeGatewayCustomer(
          $this,
            $this->createStripeCustomer()
        );

        $this->user->update([
          'gateway_customer_id' => $customer->id()
        ]);



        return $customer;
    }

    public function user()
    {
        return $this->user;
    }

    public function getCustomer()
    {
        return new StripeGatewayCustomer(
        $this,
          StripeCustomer::retrieve($this->user->gateway_customer_id)
      );
    }

    protected function createStripeCustomer()
    {
        return StripeCustomer::create([
        'email' => $this->user->email
      ]);
    }
}
