<?php

namespace App\Services;

use App\Contracts\PaymentFactoryInterface;
use App\Contracts\PaymentInterface;
use Exception;

class PaymentFactory implements PaymentFactoryInterface
{
    public function initializePayment(string $type): PaymentBase
    {
        if ($type == 'PlaceToPay') {
            return new PlaceToPayPayment();
        } elseif ($type == 'PayPal') {
            return new PayPalPayment();
        }

        throw new Exception('Medio de pago no soportado');
    }
}
