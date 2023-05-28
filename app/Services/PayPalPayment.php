<?php

namespace App\Services;

use App\Contracts\PaymentInterface;
use App\Domain\Order\OrderCompletedAction;
use App\Domain\Order\OrderCreateAction;
use App\Domain\Order\OrderUpdateAction;
use App\Services\core\PayPalClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PayPalPayment extends PaymentBase
{
    public function pay(Request $request): void
    {
        Log::info('[PAY]: Pago con PayPal');

        $clientId = config('services.paypal.clientId');
        $secretKey = config('services.paypal.secretKey');
        $urlResource = config('services.paypal.urlResource');

        $paypalClient = new PayPalClient($clientId, $secretKey, $urlResource);
        $paypalClient->setCurrency('USD')
            ->setReference(uniqid())
            ->setTotal('25.0')
            ->setReturnUrl(route('payments.return'))
            ->setCancel(route('payments.cancel'));

        $orderPayPal = $paypalClient->createOrder();

        $order = OrderCreateAction::execute($request->all());

        $order->url = $orderPayPal['link'];
        $order->order_id = $orderPayPal['order_id'];
        OrderUpdateAction::execute($order);

        redirect()->to($orderPayPal['link'])->send();
    }

    public function sendNotification()
    {
        Log::info('[PAY]: Enviamos la notificacion PayPal');
    }

    public function payOrder(Request $request)
    {
        $orderId = $request->get('token');
        $paypalClient = resolve(PayPalClient::class);
        $result = $paypalClient->payOrder($orderId);

        if ($result == 'COMPLETED') {
            OrderCompletedAction::execute($orderId);
            return view('payments.success', [
                'processor' => session()->get('payment_type'),
                'status' => 'COMPLETED'
            ]);
        }
    }
}
