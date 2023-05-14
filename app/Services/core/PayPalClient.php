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
        private string $urlResource
    )
    {

    }

    public function getToken(): self
    {
        $result = Http::asForm()
            ->withBasicAuth($this->clientId, $this->secretKey)
            ->post($this->urlResource . 'v1/oauth2/token', [
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
        $this->getToken();

        $uniqid = uniqid();
        session()->put('PayPal-Request-Id', $uniqid);

        $order = Http::
        withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
            'PayPal-Request-Id' => $uniqid,
        ])->post($this->urlResource . 'v2/checkout/orders',
            $this->getOrder()
        );

        if ($order->created()) {
            $links = collect($order->json()['links'])->where('rel', '=', 'approve')->first();
            $link = $links['href'];

            return [
                'order_id' => $order->json()['id'],
                'link' => $link,
            ];
        }

        return [];
    }


    public function setReference(string $reference): self
    {
        $this->referenceId = $reference;

        return $this;
    }

    public function setCurrency(string $currency): self
    {
        $this->currency = $currency;

        return $this;
    }

    public function setTotal(string $total): self
    {
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
            'intent' => 'CAPTURE',
            'purchase_units' => [
                [
                    "reference_id" => $this->referenceId,
                    'amount' => [
                        'currency_code' => $this->currency,
                        'value' => $this->total,
                    ],
                ]
            ],
            'application_context' => [
                'return_url' => $this->returnUrl,
                'cancel_url' => $this->cancelUrl,
            ]
        ];
    }

    public function payOrder(string $order_id): string
    {
        $this->getToken();
        $result = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->token
        ])
            ->post($this->urlResource . "v2/checkout/orders/$order_id/capture", [
                'application_context' => [
                    'return_url' => "",
                    'cancel_url' => ""
                ]
            ]);


        return $result->json()['status'];
    }
}
