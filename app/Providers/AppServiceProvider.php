<?php

namespace App\Providers;

use App\Contracts\PaymentFactoryInterface;
use App\Services\core\PayPalClient;
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

        $this->app->singleton(PayPalClient::class, function () {
            $clientId = config('services.paypal.clientId');
            $secretKey = config('services.paypal.secretKey');
            $urlResource = config('services.paypal.urlResource');

            return new PayPalClient($clientId, $secretKey, $urlResource);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
