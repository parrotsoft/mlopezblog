<?php

namespace App\Http\Controllers;

use App\ViewModels\OrderViewModel;
use Illuminate\Contracts\View\View;

class OrderController extends Controller
{
    public function index(): View
    {
        return view('orders.index', new OrderViewModel());
    }
}
