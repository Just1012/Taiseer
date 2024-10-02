<?php

namespace App\Payments;

class PaymentFactory
{
    public static function initialize($method, $amount, $shipment, $userId, $paymentMethod)
    {
        switch ($method) {
            case 'cash':
                return new CashPayment($amount, $shipment, $userId, $paymentMethod);
            case 'online':
                return new OnlinePayment($amount, $shipment, $userId, $paymentMethod);
            default:
                throw new \Exception("Unsupported payment method: {$method}");
        }
    }
}
