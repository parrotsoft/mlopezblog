<?php

namespace App\Services;

use App\Contracts\PaymentInterface;
use App\Domain\Order\OrderCreateAction;
use App\Services\core\PlacetoPayClient;
use Illuminate\Http\Request;
use App\Domain\Order\OrderCreateAction;
use App\Domain\Order\OrderUpdateAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PlaceToPayPayment extends PaymentBase
{
    public function pay(Request $request): void
    {
        Log::info('[PAY]: Pago con PlaceToPay');

        $login = config('services.placetopay.login');
        $tranKey = config('services.placetopay.tranKey');
        $baseUrl = config('services.placetopay.baseUrl');
        $timeout = config('services.placetopay.timeout');

        $placetoPayClient = new PlacetoPayClient($login, $tranKey, $baseUrl, $timeout);
        $placetoPayClient->setCurrency('USD')
            ->setReference(uniqid())
            ->setTotal('2.0')
            ->setReturnUrl(route('payments.return'))
            ->setDescription('Pago de zapatos');

        $order = $placetoPayClient->createOrder();
        $requestId = $order->requestId;
        $processUrl = $order->processUrl;

        OrderCreateAction::execute([
            'order_id' => $requestId,
            'provider' => 'PlacetoPay',
            'url' => $processUrl,
            'amount' => '2.0',
            'currency' => 'USD',
            'status' => 'CREATE',
        ]);

        redirect()->to($processUrl)->send();

    }

    public function sendNotification()
    {
        Log::info('[PAY]: Enviamos la notificacion PlaceToPay');
    }

    public function payOrder(Request $request)
    {
        dd($request);
    }
}
