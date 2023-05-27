<?php

namespace App\Services;

use App\Contracts\PaymentInterface;
use App\Domain\Order\OrderCompletedAction;
use App\Domain\Order\OrderCreateAction;
use App\Services\core\PayPalClient;
use Illuminate\Http\Request;
use App\Domain\Order\OrderCreateAction;
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

        $order = $paypalClient->createOrder();

        OrderCreateAction::execute([
            'order_id' => $order['order_id'],
            'provider' => 'PayPal',
            'url' => $order['link'],
            'amount' => '25.0',
            'currency' => 'USD',
        ]);

        redirect()->to($order['link'])->send();
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
                'processor' => session()->get('payment_type')
            ]);
        }
    }
}
