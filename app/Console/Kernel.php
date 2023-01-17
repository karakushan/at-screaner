<?php

namespace App\Console;

use App\Models\Exchange;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('exchange:update_symbols binance')->everyFourHours();
        $schedule->command('exchange:update_symbols bybit')->everyFourHours();

        $seconds = 5;
        $schedule->call(function () use ($seconds) {
            $dt = Carbon::now();
            $x = 60 / $seconds;
            $exchanges = Exchange::all();
            do {
                foreach ($exchanges as $exchange) {
                    \Artisan::call('exchange:update_prices all');
                }
                time_sleep_until($dt->addSeconds($seconds)->timestamp);
            } while ($x-- > 1);
        })->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }


}
