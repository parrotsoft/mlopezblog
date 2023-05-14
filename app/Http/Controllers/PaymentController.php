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
        session()->put('payment_type', $request->get('payment_type'));
        $processor = $paymentFactory->initializePayment($request->get('payment_type'));
        $processor->pay();

        // $this->sendEmail($processor);
    }

    private function sendEmail(PaymentBase $base): void
    {
        $base->sendNotification();
    }

    public function returnPayment(Request $request, PaymentFactoryInterface $paymentFactory)
    {

        $processor = $paymentFactory->initializePayment(session()->get('payment_type'));
        return $processor->payOrder($request);
    }

    public function cancelPayment(Request $request)
    {
        dd($request->all());
    }
}
