<?php

namespace App\Http\Livewire;

use App\Models\Symbol;
use Livewire\Component;

class SymbolTable extends Component
{
    public $symbol=null;

    public function mount(Symbol $symbol)
    {
        $this->symbol = $symbol;
    }

    public function render()
    {
        return view('livewire.symbol-table');
    }
}
