<?php

namespace App\Domain\Order;

use App\Models\Order;
use Illuminate\Database\Eloquent\Model;

class OrderGetAction
{
    public static function execute(int $id): Order|Model
    {
        return Order::query()->find($id);
    }
}
