<?php

namespace App\Domain\Order;

use App\Models\Order;
use Illuminate\Database\Eloquent\Model;

class OrderCreateAction
{
    public static function execute(array $data): Model
    {
        return Order::query()->create($data);
    }
}
