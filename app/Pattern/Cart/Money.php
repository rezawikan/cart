<?php

namespace App\Pattern\Cart;

use Money\Currency;
use NumberFormatter;
use Money\Money as BaseMoney;
use Money\Currencies\ISOCurrencies;
use Money\Formatter\IntlMoneyFormatter;

/**
 *
 */
class Money
{
    protected $money;

    public function __construct($value)
    {
        $this->money = new BaseMoney($value, new Currency('IDR'));
    }

    public function amount()
    {
      return $this->money->getAmount();
    }

    public function formatted()
    {
        $formatter = new IntlMoneyFormatter(
                        new NumberFormatter('id_ID', NumberFormatter::CURRENCY),
                        new ISOCurrencies()
                      );

        return $formatter->format($this->money);
    }

    public function nonFormatted()
    {
        return $this->amount;
    }
}
