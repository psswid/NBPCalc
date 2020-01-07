<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;


class NbpService
{
    private $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function getCalculatedCurrencies($value)
    {
        $usdJson = $this->httpClient->request('GET', 'http://api.nbp.pl/api/exchangerates/rates/a/usd/?format=json')->getContent();
        $eurJson = $this->httpClient->request('GET', 'http://api.nbp.pl/api/exchangerates/rates/a/eur/?format=json')->getContent();

        $usdJson = json_decode($usdJson)->rates;
        $usdRate = array_pop($usdJson)->mid;
        $eurJson = json_decode($eurJson)->rates;
        $eurRate = array_pop($eurJson)->mid;

        $usdCalculation = $value * $usdRate;
        $eurCalculation = $value * $eurRate;

        return [$usdCalculation, $eurCalculation];
    }
}