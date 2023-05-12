<?php
declare(strict_types=1);

namespace App\Services\core;

use Illuminate\Support\Facades\Http;

class PayPalClient
{

    private string $token = '';
    private string $referenceId = '';
    private string $currency = '';
    private string $total = '';
    private string $returnUrl = '';
    private string $cancelUrl = '';

    public function __construct(
        private string $clientId,
        private string $secretKey,
        private string $urlResource)
    {

    }

    public function getToken(): self
    {
        $result = Http::asForm()
            ->withBasicAuth($this->clientId, $this->secretKey)
            ->post($this->urlResource . 'oauth2/token', [
                'grant_type' => 'client_credentials'
            ]);

        if ($result->ok()) {
            $this->token = $result->json()['access_token'];
            session()->put('token_paypal', $this->token);
        }

        return $this;
    }

    public function createOrder(): array
    {
        $order = Http::
        withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->post($this->urlResource.'checkout/orders',
            $this->getOrder()
        );

        if ($order->created()) {
            $links = collect($order->json()['links'])->where('method','=','REDIRECT')->first();
            $link = $links['href'];

            return [
                'order_id' => $order->json()['id'],
                'link' => $link ,
            ];
        }

        return [];
    }


    public function setReference(string $reference): self
    {
        $this->referenceId = $reference;

        return $this;
    }

    public function setCurrency(string $currency): self {
        $this->currency = $currency;

        return $this;
    }

    public function setTotal(string $total): self {
        $this->total = $total;

        return $this;
    }

    public function setReturnUrl(string $url): self
    {
        $this->returnUrl = $url;

        return $this;
    }

    public function setCancel(string $url): self
    {
        $this->cancelUrl = $url;

        return $this;
    }

    private function getOrder(): array
    {
        return [
            'purchase_units' => [
                [
                    "reference_id" => $this->referenceId,
                    'amount' => [
                        'currency' => $this->currency,
                        'total' => $this->total,
                    ],
                ]
            ],
            'redirect_urls' => [
                'return_url' => $this->returnUrl,
                'cancel_url' => $this->cancelUrl,
            ]
        ];
    }
    public function payOrder(string $order_od): void
    {
        $result = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->token])
            ->post(config('services.paypal.urlResource')."checkout/orders/$order_od/pay");

        dd($result);
    }
}
