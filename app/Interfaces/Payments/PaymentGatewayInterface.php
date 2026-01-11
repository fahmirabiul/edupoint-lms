<?php

namespace App\Interfaces\Payments;

interface PaymentGatewayInterface
{
    public function charge(float $amount, array $paymentDetails): bool;
}
