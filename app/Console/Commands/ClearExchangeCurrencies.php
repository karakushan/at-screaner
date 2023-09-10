<?php

namespace App\Console\Commands;

use App\Models\Currency;
use App\Models\Exchange;
use Illuminate\Console\Command;

class ClearExchangeCurrencies extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'exchange:currencies-clear {exchange}';

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
        Currency::query()->where('exchange_id', $exchange)->delete();
        return Command::SUCCESS;
    }
}
