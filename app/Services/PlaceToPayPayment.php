<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class PlaceToPayPayment
{
    public function pay(): void
    {
        Log::info('[PAY]: Pago con PlaceToPay');
    }
}
