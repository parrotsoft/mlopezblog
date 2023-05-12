<?php

namespace App\Services;

use App\Contracts\PaymentInterface;
use App\Services\core\PayPalClient;
use Illuminate\Support\Facades\Log;

class PayPalPayment extends PaymentBase
{
    public function pay(): void
    {
        Log::info('[PAY]: Pago con PayPal');

        $clientId = config('services.paypal.clientId');
        $secretKey = config('services.paypal.secretKey');
        $urlResource = config('services.paypal.urlResource');

        $paypalClient = new PayPalClient($clientId, $secretKey, $urlResource);
        $paypalClient->getToken()
            ->setCurrency('USD')
            ->setReference(uniqid())
            ->setTotal('1.0')
            ->setReturnUrl(route('payments.return'))
            ->setCancel(route('payments.cancel'));

        $order = $paypalClient->createOrder();

        redirect()->to($order['link'])->send();
    }

    public function sendNotification()
    {
        Log::info('[PAY]: Enviamos la notificacion PayPal');
    }
}
