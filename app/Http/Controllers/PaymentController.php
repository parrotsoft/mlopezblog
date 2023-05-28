<?php

namespace App\Http\Controllers;

use App\Contracts\PaymentFactoryInterface;
use App\Services\PaymentBase;
use App\Services\PlaceToPayPayment;
use App\ViewModels\PaymentModel;
use Illuminate\Http\Request;
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
        $processor->pay($request);
        /*$this->sendEmail($processor);
        return view('payments.success', [
            'processor' => $request->get('payment_type'),
            'status' => 'COMPLETED'
        ]);*/
    }

    private function sendEmail(PaymentBase $base): void
    {
        $base->sendNotification();
    }

    public function processResponse(PlaceToPayPayment $placeToPayPayment)
    {
        return $placeToPayPayment->getRequestInformation();
    }
}
