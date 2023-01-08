<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Http;
use Livewire\Component;

class CoinsTable extends Component
{
    public $coins = [];

    // mount
    public function mount()
    {
        $headers = [
            'Accepts' => 'application/json',
            'X-CMC_PRO_API_KEY' => env('COINMARKETCAP_API_KEY')
        ];

        $mc = Http::withoutVerifying()
            ->withHeaders($headers)
            ->get('https://api.coingecko.com/api/v3/coins/list');

        $this->coins = $mc->json();
    }

    public function render()
    {
        dd($this->coins);
        return view('livewire.coins-table');
    }
}
