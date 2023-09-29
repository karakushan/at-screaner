<?php

namespace App\Console\Commands;

use App\Models\SymbolPrice;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ClearPrices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'prices:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Очищает таблицу цен';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        SymbolPrice::truncate();

        return Command::SUCCESS;
    }
}
