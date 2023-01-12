<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class BinanceApi
{
    private $api_key;
    private $api_secret;
    private $base_url = 'https://api.binance.com/api/v3';

    private $headers;

    public function __construct()
    {
        $this->api_key = env('BINANCE_API_KEY');
        $this->api_secret = env('BINANCE_API_SECRET');

        $this->headers = [
            'Accepts' => 'application/json',
            'X-MBX-APIKEY' => $this->api_key,
        ];
    }

    /**
     * Gets information about all available pairs
     *
     * @see https://binance-docs.github.io/apidocs/spot/en/#exchange-information
     *
     * @return array
     */
    public function exchange_info(): Collection
    {
        $symbols = cache()->remember('binance_exchange_info', 60 * 60, function () {
            $response = Http::withHeaders($this->headers)
                ->withoutVerifying()
                ->get($this->base_url . '/exchangeInfo');
            if ($response->successful()) {
                $data = $response->json();
                return $data['symbols'] ?? [];
            }

            return [];
        });

        return collect($symbols ?? []);
    }


    /**
     * Gets the price for a specific pair or all pairs
     *
     * @return Collection
     */
    public function get_prices(): Collection
    {
        $prices = collect();
        $response = Http::withHeaders($this->headers)
            ->withoutVerifying()
            ->get($this->base_url . '/ticker/price');
        if ($response->successful()) {
            $data = $response->json();
            $prices = collect($data);
        }

        return $prices;
    }

}
