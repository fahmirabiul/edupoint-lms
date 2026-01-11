<?php

namespace App\Factories;

use App\Interfaces\Payments\PaymentGatewayInterface;
use App\Services\Payments\MidtransPayment;
use App\Services\Payments\ManualTransferPayment;
use Exception;

class PaymentFactory
{
    public static function make(string $type): PaymentGatewayInterface
    {
        return match (strtolower($type)) {
            'midtrans' => new MidtransPayment(),
            'manual' => new ManualTransferPayment(),
            default => throw new Exception("Unsupported payment type: {$type}"),
        };
    }
}
