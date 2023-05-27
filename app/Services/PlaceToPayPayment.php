<?php

namespace App\Services;

use App\Domain\Order\OrderCreateAction;
use App\Domain\Order\OrderUpdateAction;
use App\Services\core\PlacetoPayClient;
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

        $orderP2p = $placetoPayClient->createOrder();
        $requestId = $orderP2p->requestId;
        $processUrl = $orderP2p->processUrl;

        $order = OrderCreateAction::execute($request->all());
        $order->order_id = $requestId;
        $order->url = $processUrl;

        OrderUpdateAction::execute($order);

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
