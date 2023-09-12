<?php

namespace App\Orchid\Screens\Exchanges;

use App\Models\Currency;
use App\Models\Exchange;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Picture;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Screen;
use \Orchid\Support\Facades\Layout;

class CurrencyEditScreen extends Screen
{
    public $model = null;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Currency $currency): iterable
    {
        $this->model = $currency;

        return [
            'currency' => $currency
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->model->exists ? sprintf('Edit Currency "%s"', $this->model->name) : 'Create Currency';
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
                Input::make('currency.name')
                    ->type('text')
                    ->title('Name:')
                    ->required(),

                Picture::make('currency.logo')->title('Logo:'),

                Relation::make('currency.exchange_id')
                    ->fromModel(Exchange::class, 'name')
                    ->title('Exchange:')
                    ->required(),

                Input::make('currency.chain')
                    ->type('text')
                    ->title('Chain:'),

                Quill::make('currency.description')->title('Description:'),

                CheckBox::make('currency.delisted')->title('Delisted:'),
                CheckBox::make('currency.withdraw_disabled')->title('Withdraw disabled:'),
                CheckBox::make('currency.deposit_disabled')->title('Deposit disabled:'),
                CheckBox::make('currency.trade_disabled')->title('Trade disabled:'),

                Button::make('Save')->method('save')->class('btn btn-primary'),
            ]),
        ];
    }

    function save(Currency $currency, Request $request)
    {
        $currency->fill($request->get('currency'))->save();

        return redirect()->route('platform.currencies.index');
    }
}
