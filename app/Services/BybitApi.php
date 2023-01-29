<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use App\Services\Traits\ExchangeUtilities;


class BybitApi
{
    private $base_url = 'https://api.bybit.com';
    private $headers = [];
    private $api_key = '';
    private $api_secret = '';
    private $timestamp = 0;
    private $recv_window = 5000;
    private $sign_type = 2;

    use ExchangeUtilities;

    public function __construct()
    {
        $this->base_url = config('exchanges.bybit.base_url');
        $this->api_key = config('exchanges.bybit.api_key');
        $this->api_secret = config('exchanges.bybit.api_secret');
        $this->timestamp = time() * 1000;
    }

    function get($endpoint, $params = [], $auth_headers = false)
    {
        $url = $this->base_url . $endpoint;

        if ($auth_headers) {
            $this->headers['X-BAPI-API-KEY'] = $this->api_key;
            $this->headers['X-BAPI-SIGN'] = $this->create_signature($params);
            $this->headers['X-BAPI-TIMESTAMP'] = $this->timestamp;
            $this->headers['X-BAPI-RECV-WINDOW'] = $this->recv_window;
            $this->headers['X-BAPI-SIGN-TYPE'] = $this->sign_type;
        } else {
            $params = $this->create_signature($params);
        }

        $response = Http::withHeaders($this->headers)
            ->withoutVerifying()
            ->get($url, $params);
        if ($response->successful()) {
            $data = $response->json();
            return $data;
        }

        return [];
    }

    /**
     * @param $params
     * @param $in_headers
     * @return string
     */
    private function create_signature($params): string
    {
        $query_string = http_build_query($params);
        $params_for_signature = $this->timestamp . $this->api_key . $this->recv_window . $query_string;
        return hash_hmac('sha256', $params_for_signature, $this->api_secret);
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

    // get currencies
    function get_currencies($params = []): Collection
    {
        $data = $this->get('/asset/v3/private/coin-info/query', $params, true);

        return collect($data['result']['rows'] ?? []);
    }
}
