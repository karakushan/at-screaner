<?php

namespace App\Orchid\Layouts\Exchanges;

use App\Models\Exchange;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Button;

class ExchangesListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'exchanges';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('id')->sort(),
            TD::make('name')->sort(),
            TD::make('slug'),
            TD::make('created_at')
                ->render(fn(Exchange $exchange)=>$exchange->created_at->format('d.m.Y H:i'))
                ->sort(),
            TD::make('updated_at')
                ->render(fn(Exchange $exchange)=>$exchange->created_at->format('d.m.Y H:i'))
                ->sort(),
            TD::make(__('Action'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(function (Exchange $exchange) {
                    return DropDown::make()
                        ->icon('options-vertical')
                        ->list([
                            Link::make(__('Edit'))
                                ->route('platform.exchange.edit',$exchange)
                                ->canSee($exchange->exists)
                                ->icon('pencil'),

                            Button::make(__('Delete'))
                                ->icon('trash')
                                ->method('remove')
                                ->confirm(__('Are you sure?'))
                                ->parameters([
                                    'id' => $exchange->id,
                                ]),
                        ]);
                }),

        ];
    }
}
