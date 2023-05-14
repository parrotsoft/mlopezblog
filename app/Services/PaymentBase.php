<?php

namespace App\Services;


use Illuminate\Http\Request;

abstract class PaymentBase
{
    abstract public function pay();

    abstract public function sendNotification();

    abstract public function payOrder(Request $request);
}
