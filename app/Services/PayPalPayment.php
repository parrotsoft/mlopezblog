<?php

namespace App\Services;

use App\Contracts\PaymentInterface;
use Illuminate\Support\Facades\Log;

class PayPalPayment implements PaymentInterface
{
    public function pay(): void
    {
        Log::info('[PAY]: Pago con PayPal');
    }
}
