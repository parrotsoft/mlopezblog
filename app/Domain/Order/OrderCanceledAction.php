<?php

namespace App\Domain\Order;

class OrderCanceledAction
{
    public static function execute(string $orderId)
    {
        OrderGetAction::execute($orderId)->canceled();
    }

}
