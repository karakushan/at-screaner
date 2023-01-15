<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class BybitApi
{
    private $base_url = 'https://api.bybit.com';
    private $headers = [];

    public function __construct()
    {
        $this->base_url = config('exchanges.bybit.base_url');
    }

    function get($endpoint, $params = [])
    {
        $params['sign'] = $this->create_signature($params);

        $url = $this->base_url . $endpoint;
        $response = Http::withHeaders($this->headers)
            ->withoutVerifying()
            ->get($url, $params);
        if ($response->successful()) {
            $data = $response->json();
            return $data;
        }

        return [];
    }

    function create_signature($params)
    {
        $params['api_key'] = config('exchanges.bybit.api_key');
        $params['timestamp'] = time() * 1000;
        $params['recv_window'] = 5000;
        $query_string = http_build_query($params);
        $signature = hash_hmac('sha256', $query_string, config('exchanges.bybit.api_secret'));
        return $signature;
    }

    /**
     * Gets the price for a specific pair or all pairs
     *
     * @param string $symbol
     * @return Collection
     */
    function get_prices(string $symbol = ''): Collection
    {
        $params = [
            'symbol' => $symbol,
        ];
        $endpoint = '/spot/v3/public/quote/ticker/price';
        $data = $this->get($endpoint, $params);

        return collect($data['result']['list'] ?? []);
    }

    // get all symbols
    function get_symbols(): Collection
    {
        $endpoint = '/spot/v3/public/symbols';
        $data = $this->get($endpoint);
     
        return collect($data['result']['list'] ?? []);
    }


}
