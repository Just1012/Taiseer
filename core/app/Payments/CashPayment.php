<?php

namespace App\Payments;

use App\Models\Transaction;

class CashPayment extends Payment
{
    protected $shipment;
    protected $userId;
    protected $paymentMethod;

    public function __construct($amount, $shipment, $userId, $paymentMethod)
    {
        parent::__construct($amount);
        $this->shipment = $shipment;
        $this->userId = $userId;
        $this->paymentMethod = $paymentMethod;
    }

    public function pay()
    {
        // Create a transaction record
        $transaction = Transaction::create([
            'reference_no' => 'TRX-' . strtoupper(uniqid()),
            'user_id' => $this->userId,
            'amount' => $this->amount,
            'transaction_type' => 'credit', // Example transaction type
            'status' => 'completed', // Mark the transaction as completed
            'payment_method' => $this->paymentMethod,
            'shipment_id' => $this->shipment->id,
        ]);

        return [
            "Paid {$this->amount} using Cash.",
            $transaction
        ];
    }
}
