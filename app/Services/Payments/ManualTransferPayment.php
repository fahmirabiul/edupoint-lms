<?php

namespace App\Services\Payments;

use App\Interfaces\Payments\PaymentGatewayInterface;
use Illuminate\Support\Facades\Log;

class ManualTransferPayment implements PaymentGatewayInterface
{
    public function charge(float $amount, array $paymentDetails): bool
    {
        // Simulasi panggil API Midtrans
        Log::info('Connecting to MANUAL TRANSFER process...');
        Log::info("Charging {$amount} via MANUAL TRANSFER with details: ", $paymentDetails);
        return true;
    }
}
