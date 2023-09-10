<?php

namespace App\Orchid\Screens\Exchanges;

use App\Models\Exchange;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Picture;
use Orchid\Screen\Screen;
use \Orchid\Support\Facades\Layout;

class ExchangeEditScreen extends Screen
{
    public $model = null;
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Exchange $exchange): iterable
    {
        $this->model = $exchange;

        return [
            'exchange' => $exchange
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return  $this->model->exists ? sprintf('Edit Exchange "%s"',$this->model->name) : 'Create Exchange';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::rows([
                Input::make('exchange.name')
                    ->type('text')
                    ->title('Name:'),

                Input::make('exchange.slug')
                    ->type('text')
                    ->title('Slug:'),

                Input::make('exchange.trade_link')
                    ->type('text')
                    ->title('Trade Link Template:'),

                Input::make('exchange.withdraw_url')
                    ->type('text')
                    ->title('Withdraw Link Template:'),

                Input::make('exchange.deposit_url')
                    ->type('text')
                    ->title('Deposit Link Template:'),

                Picture::make('exchange.logo_url')
                    ->title('Logo:'),

                Button::make('Save')->method('save')->class('btn btn-primary'),
            ]),
        ];
    }

    function save(Exchange $exchange,Request $request){
        $exchange->fill($request->get('exchange'))->save();

        return redirect()->route('platform.exchanges.index');
    }
}
