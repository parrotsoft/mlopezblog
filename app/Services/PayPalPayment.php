<?php

namespace App\Services;

use App\Domain\Order\OrderCreateAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PayPalPayment extends PaymentBase
{
    public function pay(Request $request): void
    {
        Log::info('[PAY]: Pago con PayPal');

        $order = OrderCreateAction::execute($request->all());
    }

    public function sendNotification()
    {
        Log::info('[PAY]: Enviamos la notificacion PayPal');
    }
}
