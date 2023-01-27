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
        foreach ($currencies as $currency) {
            $bar->advance();
            $curr = \App\Models\Currency::updateOrCreate(
                ['name' => $currency['currency']],
                [
                    'exchange_id' => $gate->id,
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


}
