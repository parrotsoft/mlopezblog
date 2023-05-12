<?php
declare(strict_types=1);

namespace App\Domain\Order;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderCreateAction
{
    public static function execute(array $data): void
    {
        $data['user_id'] = Auth::user()->getAuthIdentifier();
        Order::query()->create($data);
    }
}
