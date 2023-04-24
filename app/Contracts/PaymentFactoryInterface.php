<?php

namespace App\Contracts;

use App\Services\PaymentBase;

interface PaymentFactoryInterface
{
    public function initializePayment(string $type): PaymentBase;
}
