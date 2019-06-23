<?php

namespace App\Payment;

use App\Payment\Gateway\Xendit;
use App\Payment\Contract\PaymentContract;
use Hashids\Hashids;

class XenditPayment implements PaymentContract
{
    protected $xendit;
    protected $hashids;

    public function __construct()
    {
        $this->xendit = new Xendit;
        $this->hashids = new Hashids('',10);
    }

    public function pay($order)
    {
      return $this->xendit->createInvoice($this->hashids->encodeHex($order->id), $order->total);
    }
}
