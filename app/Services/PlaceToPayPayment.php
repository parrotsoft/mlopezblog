<?php

namespace App\Services;

use App\Contracts\PaymentInterface;
use Illuminate\Support\Facades\Log;

class PlaceToPayPayment extends PaymentBase
{
    public function pay(): void
    {
        Log::info('[PAY]: Pago con PlaceToPay');
    }

    public function sendNotification()
    {
        Log::info('[PAY]: Enviamos la notificacion PlaceToPay');
    }
}
