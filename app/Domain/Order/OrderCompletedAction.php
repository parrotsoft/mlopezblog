<?php

namespace App\Domain\Order;

class OrderCompletedAction
{
    public static function execute(string $orderId)
    {
        OrderGetAction::execute($orderId)->completed();
    }
}
