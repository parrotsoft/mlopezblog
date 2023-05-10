<?php

namespace App\Services;

use App\Contracts\PaymentInterface;
use Illuminate\Support\Facades\Log;

class PayPalPayment extends PaymentBase
{
    public function pay(): void
    {
        Log::info('[PAY]: Pago con PayPal');
    }

    public function sendNotification()
    {
        Log::info('[PAY]: Enviamos la notificacion PayPal');
    }
}
