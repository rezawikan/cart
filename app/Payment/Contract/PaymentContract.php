<?php

namespace App\Payment\Contract;

interface PaymentContract
{
   public function pay($request);
}
