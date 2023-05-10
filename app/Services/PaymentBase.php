<?php

namespace App\Services;

abstract class PaymentBase
{
    abstract public function pay();

    abstract public function sendNotification();
}
