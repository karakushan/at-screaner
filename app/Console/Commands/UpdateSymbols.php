<?php

namespace App\Console\Commands;

use App\Models\Symbol;
use App\Services\BinanceApi;
use App\Services\BybitApi;
use App\Services\GateApi;
use App\Services\WhitebitApi;
use Illuminate\Console\Command;
use \App\Models\Exchange;

class UpdateSymbols extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'exchange:update_symbols {exchange}';

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
                $this->{$exchange->slug}();
            }
        } else {
            if (method_exists($this, $exchange)) {
                $this->$exchange();
            } else {
                $this->error('Exchange not found');
            }
        }

        return Command::SUCCESS;
    }

    private function binance()
    {
        $exchange = Exchange::where('slug', 'binance')->firstOrFail();

        $api = new BinanceApi();
        $symbols = $api->exchange_info();
        $symbols = $symbols->filter(function ($value, $key) {
            return $value['status'] == 'TRADING';
        });

        $attach = [];
        $symbols->each(function ($symbol) use (&$attach) {
            $sym = Symbol::updateOrCreate([
                'name' => $symbol['symbol'],
                'base_currency' => $symbol['baseAsset'],
                'quote_currency' => $symbol['quoteAsset'],
            ], [
                'name' => $symbol['symbol'],
                'base_currency' => $symbol['baseAsset'],
                'quote_currency' => $symbol['quoteAsset']
            ]);
            $attach[] = $sym->id;
        });

        // atach symbols
        $exchange->symbols()->sync($attach);

    }

    private function bybit()
    {
        $exchange = Exchange::where('slug', 'bybit')->firstOrFail();

        $api = new BybitApi();
        $symbols = $api->get_symbols();

        $symbols = $symbols->filter(function ($value, $key) {
            return $value['showStatus'] == '1';
        });

        $attach = [];
        $symbols->each(function ($symbol) use (&$attach) {
            $sym = Symbol::updateOrCreate([
                'name' => $symbol['name'],
                'base_currency' => $symbol['baseCoin'],
                'quote_currency' => $symbol['quoteCoin'],
            ], [
                'name' => $symbol['name'],
                'base_currency' => $symbol['baseCoin'],
                'quote_currency' => $symbol['quoteCoin'],
            ]);

            $attach[] = $sym->id;
        });

        $exchange->symbols()->sync($attach);
    }

    private function whitebit()
    {
        $api = new WhitebitApi();
        $symbols = $api->get_symbols();
        $exchange = Exchange::where('slug', 'whitebit')->firstOrFail();

        $symbols = $symbols->filter(function ($value, $key) {
            return $value['type'] == 'spot' && $value['tradesEnabled'] == true;
        });

        $attach = [];
        $symbols->each(function ($symbol) use (&$attach) {
            $sym = Symbol::updateOrCreate([
                'name' => $symbol['stock'] . $symbol['money'],
                'base_currency' => $symbol['stock'],
                'quote_currency' => $symbol['money'],
            ], [
                'name' => $symbol['stock'] . $symbol['money'],
                'base_currency' => $symbol['stock'],
                'quote_currency' => $symbol['money'],
            ]);

            $attach[] = $sym->id;
        });

        $exchange->symbols()->sync($attach);
    }

    private function gate()
    {
        $exchange = Exchange::where('slug', 'gate')->firstOrFail();

        $api = new GateApi();
        $symbols = $api->get_symbols();

        $symbols = $symbols->filter(function ($value, $key) {
            return $value['trade_status'] == 'tradable';
        });

        $attach = [];
        $symbols->each(function ($symbol) use (&$attach) {
            $name = implode('', [$symbol['base'], $symbol['quote']]);
            $sym = Symbol::updateOrCreate([
                'name' => $name,
                'base_currency' => $symbol['base'],
                'quote_currency' => $symbol['quote'],
            ], [
                'name' => $name,
                'base_currency' => $symbol['base'],
                'quote_currency' => $symbol['quote'],
            ]);

            $attach[] = $sym->id;
        });

        $exchange->symbols()->sync($attach);
    }

}
