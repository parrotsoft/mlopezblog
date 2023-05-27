<?php

namespace App\Domain\Order;

use App\Models\Order;
use Illuminate\Database\Eloquent\Model;

class OrderCreateAction
{
    public static function execute(array $data): Model
    {
        $data['user_id'] = auth()->id();
        return Order::query()->create($data);
    }
}
