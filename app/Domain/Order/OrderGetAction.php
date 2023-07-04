<?php

namespace App\Domain\Order;

use App\Models\Order;

class OrderGetAction
{
    public static function execute(string $orderId): Order
    {
        return Order::query()->where('order_id', '=', $orderId)->first();
    }
}
