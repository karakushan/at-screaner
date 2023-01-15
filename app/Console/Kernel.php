<?php

namespace App\Console;

use App\Models\Exchange;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

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
    }

    protected function shortSchedule(\Spatie\ShortSchedule\ShortSchedule $shortSchedule)
    {
        // this artisan command will run every second
        $exchanges = Exchange::all();
        foreach ($exchanges as $exchange) {
            $shortSchedule->command('exchange:update_prices ' . $exchange->slug)->everySeconds();
        }
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
