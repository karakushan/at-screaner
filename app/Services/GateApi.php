<?php

namespace App\Services;

class GateApi
{
    private $base_url = 'https://api.gateio.ws/api/v4';

    function get_symbols()
    {
        $response = \Http::withoutVerifying()->get($this->base_url . '/spot/currency_pairs/');
        return collect($response->json() ?? []);
    }

    function get_prices()
    {
        $response = \Http::withoutVerifying()->get($this->base_url . '/spot/tickers');
        return collect($response->json() ?? []);
    }

}
