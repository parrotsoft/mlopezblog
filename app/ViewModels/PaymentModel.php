<?php

namespace App\ViewModels;

use App\Models\Post;
use Illuminate\Database\Eloquent\Model;
use Spatie\ViewModels\ViewModel;

class PaymentModel extends ViewModel
{
    public function __construct(public int $post_id)
    {
        //
    }

    public function post(): Model
    {
        return Post::query()->find($this->post_id);
    }

    public function paymentProcessors(): array
    {
        return [
            'PlaceToPay',
            'PayPal',
        ];
    }
}
