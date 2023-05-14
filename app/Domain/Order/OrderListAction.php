<?php

namespace App\Domain\Order;

use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;

class OrderListAction
{
    public static function execute(): Collection
    {
        return Order::all();
    }
}
