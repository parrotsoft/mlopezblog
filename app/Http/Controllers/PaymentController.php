<?php

namespace App\Http\Controllers;

use App\Contracts\PaymentFactoryInterface;
use App\Services\core\PayPalClient;
use App\Services\PaymentBase;
use App\ViewModels\PaymentModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;

class PaymentController extends Controller
{
    public function create(int $post_id): View
    {
        return view('payments.create', new PaymentModel($post_id));
    }

    public function processPayment(Request $request, PaymentFactoryInterface $paymentFactory)
    {
        $processor = $paymentFactory->initializePayment($request->get('payment_type'));
        $processor->pay();

        // $this->sendEmail($processor);
    }

    private function sendEmail(PaymentBase $base): void
    {
        $base->sendNotification();
    }

    public function returnPayment(Request $request, PayPalClient $payPalClient)
    {
        $orderId = $request->get('token');
        $result = $payPalClient->payOrder($orderId);
        if ($result == 'COMPLETED') {
            return view('payments.success', [
                'processor' => $payPalClient::class
            ]);
        }

        dd('Error ' . $result);
    }

    public function cancelPayment(Request $request)
    {
        dd($request->all());
    }
}
