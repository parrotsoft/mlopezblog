<?php

namespace App\Domain\Order;

use App\Models\Order;
use Illuminate\Database\Eloquent\Model;

class OrderGetAction
{
    public static function execute(string $orderId): Order|Model
    {
        return Order::query()->where('order_id', '=', $orderId)->first();
    }
}
