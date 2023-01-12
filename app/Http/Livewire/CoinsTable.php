<?php

namespace App\Http\Livewire;

use App\Services\BinanceApi;

use App\Services\BybitApi;
use Illuminate\Support\Collection;
use Livewire\Component;
use function Psy\debug;

class CoinsTable extends Component
{
    public $coins = [];
    public $prices = [];
    public $binance_prices = [];
    private $binanceApi;
    private $bybitApi;
    public Collection $prices_all;

    function __construct()
    {
        $this->binanceApi = new BinanceApi();
        $this->bybitApi = new BybitApi();
    }

    // mount
    public function mount()
    {
        $this->coins = $this->binanceApi->exchange_info();


    }

    private function get_prices()
    {
        $this->prices['binance'] = $this->binanceApi->get_prices();
        $this->prices['bybit'] = $this->bybitApi->get_prices();

        // удалить пары, которые не встречаются в обоих биржах
        $this->prices['binance'] = $this->prices['binance']->filter(function ($value, $key) {
            // check if symbol status is TRADING
            $symbol = $this->coins->where('symbol', $value['symbol'])->first();
            return $symbol['status'] == 'TRADING' && $this->prices['bybit']->contains('symbol', $value['symbol']);
        });

        // создать массив с ключами символов и значениями цен для всех бирж
        $prices_all = [];
        foreach ($this->prices['binance'] as $pair) {
            $price_binance = $pair['price'] ?? null;
            $price_bybit = $this->prices['bybit']->where('symbol', $pair['symbol'])->first()['price'] ?? null;

            if (!$price_binance || !$price_bybit) {
                continue;
            }

            $price_binance = floatval($price_binance);
            $price_bybit = floatval($price_bybit);
            // вычислить разницу цены в процентах
            $diff = $price_binance > $price_bybit ? ($price_binance - $price_bybit) / $price_binance * 100 : ($price_bybit - $price_binance) / $price_bybit * 100;
            $diff = round($diff, 2);

            $prices_all[$pair['symbol']] = [
                'info' => $this->coins->where('symbol', $pair['symbol'])->first(),
                'prices' => [
                    'binance' => $price_binance,
                    'bybit' => $price_bybit,
                ],
                'diff' => $diff,
            ];
        }

        $prices_all = collect($prices_all);

        $this->prices_all = $prices_all->sortByDesc('diff');
    }

    public function render()
    {
        $this->get_prices();
        return view('livewire.coins-table');
    }
}
