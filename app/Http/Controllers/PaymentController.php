<?php

namespace App\Http\Controllers;

use App\Services\PaymentFactory;
use App\ViewModels\PaymentModel;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PaymentController extends Controller
{
    public function create(int $post_id): View
    {
        return view('payments.create', new PaymentModel($post_id));
    }

    public function processPayment(Request $request)
    {
        $processor = (new PaymentFactory())->initializePayment($request->get('payment_type'));
        $processor->pay();
        return view('payments.success', [
            'processor' => $request->get('payment_type')
        ]);
    }
}
