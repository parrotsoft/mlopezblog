<?php
declare(strict_types=1);

namespace App\Services\core;

use Carbon\Carbon;
use Dnetix\Redirection\Exceptions\PlacetoPayException;
use Dnetix\Redirection\PlacetoPay;

class PlacetoPayClient
{
    public PlacetoPay $placetoPay;
    private string $referenceId = '';
    private string $currency = '';
    private string $total = '';
    private string $returnUrl = '';
    private string $description = '';
    public function __construct(
        private string $login,
        private string $trankey,
        private string $baseUrl,
        private int $timeout
    )
    {
        try {
            $this->placetoPay = new PlacetoPay([
                'login' => $this->login,
                'tranKey' => $this->trankey,
                'url' => $this->baseUrl,
                'timeout' => $this->timeout,
            ]);
        } catch (PlacetoPayException $e) {
            dd($e);
        }
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

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    private function getOrder(): array
    {
        return [
            'payment' => [
                'reference' => $this->referenceId,
                'description' => $this->description,
                'amount' => [
                    'currency' => $this->currency,
                    'total' => $this->total
                ],
            ],
            'expiration' => Carbon::now()->addDays(2),
            'returnUrl' => $this->returnUrl,
            'ipAddress' => request()->ip(),
            'userAgent' => request()->userAgent(),
        ];
    }

    public function createOrder(): \Dnetix\Redirection\Message\RedirectResponse
    {
        return $this->placetoPay->request($this->getOrder());
    }
}
