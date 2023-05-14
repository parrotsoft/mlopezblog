<?php

namespace App\ViewModels;

use App\Domain\Order\OrderListAction;
use Illuminate\Database\Eloquent\Collection;
use Spatie\ViewModels\ViewModel;

class OrderViewModel extends ViewModel
{
    public function orders(): Collection
    {
        return OrderListAction::execute();
    }
}
