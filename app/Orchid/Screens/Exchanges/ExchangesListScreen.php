<?php

namespace App\Orchid\Screens\Exchanges;

use App\Models\Exchange;
use App\Orchid\Layouts\Exchanges\ExchangesListLayout;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;

class ExchangesListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'exchanges' => Exchange::query()->latest()->paginate(10)
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Exchanges';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make(__('Create Exchange'))->icon('plus')->route('platform.exchange.create'),
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
            ExchangesListLayout::class
        ];
    }

    function remove(Exchange $exchange){
        $exchange->delete();

        return redirect()->route('platform.exchanges.index');
    }
}
