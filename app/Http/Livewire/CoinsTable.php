<?php

namespace App\Http\Livewire;

use App\Models\Symbol;
use App\Services\BinanceApi;

use App\Services\BybitApi;
use Illuminate\Support\Collection;
use Livewire\Component;
use function Psy\debug;

class CoinsTable extends Component
{
    public $symbols = [];
    public $quote_assets = [];
    public $quote_asset = '';
    public int $capital = 1000;

    function __construct()
    {

    }

    // mount
    public function mount()
    {
        $this->symbols = Symbol::with('prices')->get();
        $this->quote_assets = $this->symbols->pluck('quote_currency')->unique()->toArray();
    }

    public function render()
    {
        $this->symbols = Symbol::with('exchanges')
            ->with('prices')
            ->when($this->quote_asset, function ($query) {
                $query->where('quote_currency', $this->quote_asset);
            })
            ->withCount('prices')
            ->get()
            ->where('prices_count', '>', 1)
            ->where('spread', '>', 0)
            ->sortByDesc('spread');

        return view('livewire.coins-table');
    }
}
