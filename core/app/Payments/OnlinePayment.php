<?php

namespace App\Payments;

class OnlinePayment extends Payment
{
    public function pay()
    {
        // Logic For Online Payment
        return "Paid {$this->amount} using Online Payment.";
    }
}
