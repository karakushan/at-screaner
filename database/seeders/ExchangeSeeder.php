<?php

namespace Database\Seeders;

use App\Models\Exchange;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExchangeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $exchanges = [
            'binance' => [
                'name' => 'Binance',
            ],
            'bybit' => [
                'name' => 'Bybit',
            ],
            'whitebit' => [
                'name' => 'Whitebit',
            ],
            'gate' => [
                'name' => 'Gate.io',
            ],
        ];

        // update or create exchanges
        foreach ($exchanges as $slug => $exchange) {
            Exchange::updateOrCreate([
                'slug' => $slug,
            ], [
                'slug' => $slug,
                'name' => $exchange['name'],
            ]);
        }
    }
}
