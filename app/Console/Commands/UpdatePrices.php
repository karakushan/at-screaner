<?php

namespace App\Console\Commands;

use App\Models\Exchange;
use App\Models\Symbol;
use App\Models\SymbolPrice;
use Illuminate\Console\Command;

class UpdatePrices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'exchange:update_prices {exchange}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $exchange = $this->argument('exchange');

        // update all exchanges
        if ($exchange === 'all') {
            $exchanges = Exchange::all();
            foreach ($exchanges as $exchange) {
                if (!method_exists($this, $exchange->slug)) {
                    $this->error('Exchange "' . $exchange->slug . '" not found');
                    continue;
                }
                $start = microtime(true);
                $this->{$exchange->slug}();
                $end = microtime(true);
                $this->info(sprintf('%s - time: %s sec.', $exchange->slug, round($end - $start)));
            }
        } else {
            if (method_exists($this, $exchange)) {
                $start = microtime(true);
                $this->$exchange();
                $end = microtime(true);
                $this->info(sprintf('%s - time: %s sec.', $exchange, round($end - $start)));
            } else {
                $this->error('Exchange not found');
            }
        }

        return Command::SUCCESS;
    }

    private function binance()
    {
        $api = new \App\Services\BinanceApi();
        $exchange = Exchange::where('slug', 'binance')->firstOrFail();
        $prices = $api->get_prices();

        $symbols = [];
        $prices->each(function ($price) use ($exchange, &$symbols) {
            $symbol = Symbol::where('name', $price['symbol'])->first();
            if ($symbol && $symbol->exchanges->contains($exchange)) {
                $symbols[] = $symbol->id;
                // update or create price
                SymbolPrice::updateOrCreate([
                    'symbol_id' => $symbol->id,
                    'exchange_id' => $exchange->id,
                ], [
                    'symbol_id' => $symbol->id,
                    'exchange_id' => $exchange->id,
                    'price' => floatval($price['price']),
                ]);
            }

        });

        // delete all prices that are not in the list
        SymbolPrice::where('exchange_id', $exchange->id)
            ->whereNotIn('symbol_id', $symbols)
            ->delete();

    }

    private function bybit()
    {
        $api = new \App\Services\BybitApi();
        $exchange = Exchange::where('slug', 'bybit')->firstOrFail();
        $prices = $api->get_prices();

        $symbols = [];
        $prices->each(function ($price) use ($exchange, &$symbols) {
            $symbol = Symbol::where('name', $price['symbol'])->first();

            if ($symbol && $symbol->exchanges->contains($exchange)) {
                $symbols[] = $symbol->id;
                // update or create price
                SymbolPrice::updateOrCreate([
                    'symbol_id' => $symbol->id,
                    'exchange_id' => $exchange->id,
                ], [
                    'symbol_id' => $symbol->id,
                    'exchange_id' => $exchange->id,
                    'price' => floatval($price['price']),
                ]);
            }

        });

        // delete all prices that are not in the list
        SymbolPrice::where('exchange_id', $exchange->id)
            ->whereNotIn('symbol_id', $symbols)
            ->delete();

    }

    private function whitebit()
    {
        $api = new \App\Services\WhitebitApi();
        $exchange = Exchange::where('slug', 'whitebit')->firstOrFail();
        $prices = $api->get_prices();

        $symbols = [];
        $prices->each(function ($price, $key) use ($exchange, &$symbols) {
            $symbol = Symbol::where('name', str_replace('_', '', $key))->first();

            if ($symbol && $symbol->exchanges->contains($exchange)) {
                $symbols[] = $symbol->id;
                // update or create price
                SymbolPrice::updateOrCreate([
                    'symbol_id' => $symbol->id,
                    'exchange_id' => $exchange->id,
                ], [
                    'symbol_id' => $symbol->id,
                    'exchange_id' => $exchange->id,
                    'price' => floatval($price['last_price']),
                ]);
            }

        });

        // delete all prices that are not in the list
        SymbolPrice::where('exchange_id', $exchange->id)
            ->whereNotIn('symbol_id', $symbols)
            ->delete();
    }

    private function gate(){
        $api = new \App\Services\GateApi();
        $exchange = Exchange::where('slug', 'gate')->firstOrFail();
        $prices = $api->get_prices();

        $symbols = [];
        $prices->each(function ($price, $key) use ($exchange, &$symbols) {
            $symbol = Symbol::where('name', str_replace('_', '', $price['currency_pair']))->first();

            if ($symbol && $symbol->exchanges->contains($exchange)) {
                $symbols[] = $symbol->id;
                // update or create price
                SymbolPrice::updateOrCreate([
                    'symbol_id' => $symbol->id,
                    'exchange_id' => $exchange->id,
                ], [
                    'symbol_id' => $symbol->id,
                    'exchange_id' => $exchange->id,
                    'price' => floatval($price['last']),
                ]);
            }

        });

        // delete all prices that are not in the list
        SymbolPrice::where('exchange_id', $exchange->id)
            ->whereNotIn('symbol_id', $symbols)
            ->delete();
    }
}
