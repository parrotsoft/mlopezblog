<?php

namespace App\Services;

use App\Contracts\PaymentInterface;
use Illuminate\Support\Facades\Log;

class PlaceToPayPayment implements PaymentInterface
{
    public function pay(): void
    {
        Log::info('[PAY]: Pago con PlaceToPay');
    }
}
