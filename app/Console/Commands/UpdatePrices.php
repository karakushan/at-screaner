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

        if (method_exists($this, $exchange)) {
            $this->$exchange();
        } else {
            $this->error('Exchange not found');
        }

        return Command::SUCCESS;
    }

    private function binance()
    {
        $api = new \App\Services\BinanceApi();
        $exchange = Exchange::where('slug', 'binance')->firstOrFail();
        $prices = $api->get_prices();

        $prices->each(function ($price) use ($exchange) {

            $symbol = Symbol::where('name', $price['symbol'])->first();
            if ($symbol) {

                // update or create price
                SymbolPrice::updateOrCreate([
                    'symbol_id' => $symbol->id,
                    'exchange_id' => $exchange->id,
                ], [
                    'symbol_id' => $symbol->id,
                    'exchange_id' => $exchange->id,
                    'price' =>floatval($price['price']),
                ]);
            }

        });
    }

    private function bybit()
    {
        $api = new \App\Services\BybitApi();
        $exchange = Exchange::where('slug', 'bybit')->firstOrFail();
        $prices = $api->get_prices();

        $prices->each(function ($price) use ($exchange) {
            $symbol = Symbol::where('name', $price['symbol'])->first();

            if ($symbol) {
                // update or create price
                SymbolPrice::updateOrCreate([
                    'symbol_id' => $symbol->id,
                    'exchange_id' => $exchange->id,
                ], [
                    'symbol_id' => $symbol->id,
                    'exchange_id' => $exchange->id,
                    'price' =>floatval($price['price']),
                ]);
            }

        });
    }
}
