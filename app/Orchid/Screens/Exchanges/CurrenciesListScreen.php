<?php

namespace App\Orchid\Screens\Exchanges;

use App\Models\Currency;
use App\Models\Exchange;
use App\Models\Symbol;
use App\Orchid\Layouts\Exchanges\CurrenciesListLayout;
use App\Orchid\Layouts\Exchanges\ExchangesListLayout;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;

class CurrenciesListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'currencies' => Currency::query()->latest()->paginate(20)
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Symbols';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make(__('Create Currency'))->icon('plus')->route('platform.currency.create'),
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            CurrenciesListLayout::class
        ];
    }

    function remove(Currency $currency){
        $currency->delete();

        return redirect()->route('platform.currencies.index');
    }
}
