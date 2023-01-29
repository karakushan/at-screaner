<?php

namespace App\Console\Commands;

use App\Services\GateApi;
use Illuminate\Console\Command;

class UpdateCurrencies extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update-currencies {exchange}';

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

        if ($exchange == 'all') {
            $exchanges = \App\Models\Exchange::all();
            foreach ($exchanges as $ex) {
                if (!method_exists($this, $ex->slug))
                    continue;

                $this->{$ex->slug}();
            }
            return Command::SUCCESS;
        }

        if (!method_exists($this, $exchange)) {
            $this->error("Exchange $exchange not found");
            return Command::FAILURE;
        }

        $this->$exchange();

        return Command::SUCCESS;
    }

    function gate()
    {
        $api = new GateApi();
        $currencies = $api->get_currencies();

        $gate = \App\Models\Exchange::where('slug', 'gate')->first();

        // update or create currencies
        $ids = [];
        // make progress bar
        $bar = $this->output->createProgressBar(count($currencies));
        $bar->start();
        foreach ($currencies as $key => $currency) {
            $bar->advance();
            $curr = \App\Models\Currency::updateOrCreate(
                [
                    'name' => $currency['currency'],
                    'exchange_id' => $gate->id],
                [

                    'chain' => $currency['chain'] ?? null,
                    'delisted' => $currency['delisted'],
                    'withdraw_disabled' => $currency['withdraw_disabled'],
                    'deposit_disabled' => $currency['deposit_disabled'],
                    'trade_disabled' => $currency['trade_disabled'],
                ]
            );

            $ids[] = $curr->id;
        }
        $bar->finish();

        // delete currencies that are not in gate
//        \App\Models\Currency::where('exchange_id', $gate->id)->whereNotIn('id', $ids)->delete();

    }

    private function whitebit()
    {
        $api = new \App\Services\WhitebitApi();
        $currencies = $api->get_currencies();
        $api->saveToJson($currencies["1INCH"],'whitebit_currencies');
        exit;

        $exchange = \App\Models\Exchange::where('slug', 'whitebit')->first();
        $ids = [];
        // make progress bar
        $bar = $this->output->createProgressBar(count($currencies));
        $bar->start();
        foreach ($currencies as $key => $currency) {
            $bar->advance();
            $curr = \App\Models\Currency::updateOrCreate(
                [
                    'name' => $key,
                    'exchange_id' => $exchange->id
                ],
                [
                    'chain' => $currency['networks']['default'] ?? null,
                    'delisted' => false,
                    'withdraw_disabled' => !$currency['can_withdraw'],
                    'deposit_disabled' => !$currency['can_deposit'],
                    'trade_disabled' => false,
                    'description' => $currency['name'],
                ]
            );

            $ids[] = $curr->id;
        }
        $bar->finish();
    }

    function bybit()
    {
        $api = new \App\Services\BybitApi();
        $currencies = $api->get_currencies();

        $exchange = \App\Models\Exchange::where('slug', 'bybit')->first();
        $ids = [];
        // make progress bar
        $bar = $this->output->createProgressBar(count($currencies));
        $bar->start();
        foreach ($currencies as $key => $currency) {
            $bar->advance();

            $curr = \App\Models\Currency::updateOrCreate(
                [
                    'name' => $key,
                    'exchange_id' => $exchange->id
                ],
                [
                    'name' => $key,
                    'exchange_id' => $exchange->id
                ]
            );

            if ($currency['chains']) {
                foreach ($currency['chains'] as $chain) {
                    $curr->chains()->updateOrCreate(
                        [
                            'currency_id' => $curr->id,
                            'name' => $chain['chain'],
                            'exchange_id' => $exchange->id
                        ],
                        [
                            'type' => $chain['chainType'],
                            'can_withdraw' => $chain['chainWithdraw'] === "1",
                            'can_deposit' => $chain['chainDeposit'] === "1",
                            'withdraw_fee' => (float)$chain['withdrawFee'],
                            'withdraw_min' => (float)$chain['withdrawMin'],
                            'deposit_min' => (float)$chain['depositMin'],
                        ]
                    );
                }
            }

            $ids[] = $curr->id;
        }
        $bar->finish();
    }

}
