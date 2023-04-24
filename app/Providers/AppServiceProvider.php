<?php

namespace App\Providers;

use App\Contracts\PaymentFactoryInterface;
use App\Services\PaymentFactory;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(PaymentFactoryInterface::class, PaymentFactory::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
