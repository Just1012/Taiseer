<?php

namespace App\Payments;

abstract class Payment
{
    protected $amount;

    public function __construct($amount)
    {
        $this->amount = $amount;
    }

    abstract public function pay();
}
