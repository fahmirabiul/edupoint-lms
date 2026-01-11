<?php

namespace App\Services\Payments;

use App\Interfaces\Payments\PaymentGatewayInterface;
use Illuminate\Support\Facades\Log;

class MidtransPayment implements PaymentGatewayInterface
{
    public function charge(float $amount, array $paymentDetails): bool
    {
        // Simulasi panggil API Midtrans
        Log::info('Connecting to MIDTRANS API...');
        Log::info("Charging {$amount} via MIDTRANS with details: ", $paymentDetails);
        return true;
    }
}
