<?php

namespace App\Payment;

use App\Payment\Contract\PaymentContract;
use Illuminate\Http\Request;

class PaymentHandler
{
    protected $method;

    public function __construct(PaymentContract $method)
    {
        $this->method = $method;
    }

    public function create($order)
    {
        return $this->method->pay($order);
    }
}
