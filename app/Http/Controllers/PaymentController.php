<?php

namespace App\Http\Controllers;

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

    public function processPayment(Request $request)
    {
        if ($request->get('payment_type') == 'PlaceToPay') {
            $placeToPay = new PlaceToPayPayment();
            $placeToPay->pay();

            return view('payments.success', [
                'processor' => $request->get('payment_type')
            ]);
        }
    }
}
