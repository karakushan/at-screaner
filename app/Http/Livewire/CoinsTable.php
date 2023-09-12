<?php

namespace App\Http\Livewire;

use App\Models\Symbol;
use App\Models\SymbolPrice;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class CoinsTable extends Component
{
    use WithPagination;
    protected $paginationTheme = 'simple-tailwind';

    public $symbols = [];
    public $quote_assets = [];
    public $quote_asset = '';
    public int $capital = 1000;
    public int $min_spread = 1;
    public int $max_spread = 20;

    function __construct()
    {

    }

    // mount
    public function mount()
    {
        $this->quote_assets = $this->getQuoteAssets();
    }

    // get quote assets
    public function getQuoteAssets()
    {
        $quote_assets = Cache::get('quote_assets');
        if (!$quote_assets) {
            $quote_assets = Symbol::with('prices')->get()->pluck('quote_currency')->unique()->toArray();
            Cache::put('quote_assets', $quote_assets);
        }
        return $quote_assets;
    }

    public function render()
    {
        $symbols = DB::table('symbols AS s')
            ->join('symbol_prices AS sp1', 's.id', '=', 'sp1.symbol_id')
            ->join('symbol_prices AS sp2', function ($join) {
                $join->on('s.id', '=', 'sp2.symbol_id')
                    ->where('sp1.exchange_id', '<>', 'sp2.exchange_id');
            })
            ->select(
                's.name AS symbol_name',
                's.id AS symbol_id',
                'sp1.exchange_id AS exchange_1',
                'sp2.exchange_id AS exchange_2',
                'sp1.price AS exchange_1_price',
                'sp2.price AS exchange_2_price',
                DB::raw('((sp1.price - sp2.price) / sp1.price * 100) AS price_diff'),
            )
            ->orderBy('price_diff', 'DESC')
            ->limit(20)
            ->paginate(10);

        $this->symbols = collect($symbols->items())->map(function ($item) {
            $item->symbol = Symbol::find($item->symbol_id);
            $item->prices = SymbolPrice::query()->with('exchange')->where('symbol_id', $item->symbol_id)->get();
            $item->price_diff = round($item->price_diff, 2);
            return $item;
        });

        $links = $symbols->links();


        return view('livewire.coins-table', compact('links'));
    }
}
