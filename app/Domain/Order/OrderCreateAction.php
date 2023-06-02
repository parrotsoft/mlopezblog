<?php

namespace App\Domain\Order;

use App\Models\Order;
use Illuminate\Database\Eloquent\Model;

class OrderCreateAction
{
    public static function execute(array $data): Model
    {
        return Order::query()->create([
            'user_id' => auth()->id(),
            'provider' => $data['payment_type'],
            'amount' => $data['price'],
            'post_id' => $data['post_id'],
        ]);
    }
}
