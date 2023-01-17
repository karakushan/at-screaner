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

    function __construct()
    {

    }

    // mount
    public function mount()
    {
    }

    public function render()
    {
        $this->symbols = Symbol::with('exchanges')
            ->with('prices')
            ->get()
            ->where('spread', '>', 0)
            ->sortByDesc('spread');

        return view('livewire.coins-table');
    }
}
