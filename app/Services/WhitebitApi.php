<?php

namespace App\Services;

use Illuminate\Support\Collection;

class WhitebitApi
{
    private string $base_url = '';
    private string $api_key = '';
    private string $api_secret = '';

    public function __construct()
    {
        $this->base_url = config('exchanges.whitebit.base_url');
        $this->api_key = config('exchanges.whitebit.api_key');
        $this->api_secret = config('exchanges.whitebit.api_secret');
    }

    public function get(string $request, $params = [])
    {
        $nonce = (string)(int)(microtime(true) * 1000);
        $nonceWindow = true;
        $params = array_merge($params, [
            'request' => $request,
            'nonce' => $nonce,
            'nonceWindow' => $nonceWindow,
        ]);
        $dataJsonStr = json_encode($params, JSON_UNESCAPED_SLASHES);
        $payload = base64_encode($dataJsonStr);
        $headers = [
            'Content-type' => 'application/json',
            'X-TXC-APIKEY' => $this->api_key,
            'X-TXC-PAYLOAD' => $payload,
            'X-TXC-SIGNATURE' => hash_hmac('sha256', $payload, $this->api_secret),
        ];

        $response = \Http::withoutVerifying()->withHeaders($headers)
            ->get($this->base_url . $request, $params);

        return $response->json();
    }

    // get all symbols
    public function get_symbols(): Collection
    {
        $endpoint = '/api/v4/public/markets';
        $data = $this->get($endpoint);
        return collect($data ?? []);
    }

    // get all prices
    public function get_prices(): Collection
    {
        $endpoint = '/api/v4/public/ticker';
        $data = $this->get($endpoint);
        return collect($data ?? []);
    }

}
