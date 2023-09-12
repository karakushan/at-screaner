<div>
    <div class="flex flex-col">
        <div class="overflow-x-auto sm:mx-0.5 lg:mx-0.5">
            <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
                <form action="" class="grid grid-cols-6 gap-2 mt-6">
                    <div class="mb-6">
                        <label for="min_spread"
                               class="block mb-2 text-sm font-medium text-gray-900 whitespace-nowrap">{{ __('Минимальный спред %') }}</label>
                        <input type="number" wire:model="min_spread" id="min_spread"
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    </div>
                    <div class="mb-6">
                        <label for="max_spread"
                               class="block mb-2 text-sm font-medium text-gray-900 whitespace-nowrap">{{ __('Максимальный спред %') }}</label>
                        <input type="number" wire:model="max_spread" id="min_spread"
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                               required>
                    </div>
                    <div class="mb-6">
                        <label for="quote_asset"
                               class="block mb-2 text-sm font-medium text-gray-900 whitespace-nowrap">{{ __('Quote Asset') }}</label>
                        <select id="quote_asset"
                                wire:model="quote_asset"
                                wire:ignore
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            <option selected>{{ __('Select') }}</option>
                            @foreach($quote_assets as $quote_asset)
                                <option value="{{ $quote_asset }}">{{ $quote_asset }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-6">
                        <label for="capital"
                               class="block mb-2 text-sm font-medium text-gray-900 whitespace-nowrap">{{ __('Стартовый капитал') }}</label>
                        <input type="number" wire:model="capital" id="capital"
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    </div>
                </form>
                <div class="overflow-hidden">
                    <table class="min-w-full">
                        <thead class="bg-gray-200 border-b">
                        <tr>
                            <th scope="col" width="20" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                {{ __("ID") }}
                            </th>
                            <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                {{ __("Pair") }}
                            </th>
                            <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                {{ __('Profit') }}
                            </th>
                            <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                {{ __('Prices') }}
                            </th>
                            <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                {{ __('Spread %') }}
                            </th>

                            <th></th>
                        </tr>
                        </thead>
                        <tbody wire:poll.5s>
                        @foreach ($symbols as $name=>$pair)
                            <tr class="bg-white border-b transition duration-300 ease-in-out hover:bg-gray-100">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $pair->symbol->id }} </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $pair->symbol->base_currency }}/{{ $pair->symbol->quote_currency }} </td>
                                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="text-sm font-medium text-gray-900 border px-2 py-2 bg-blue-300 rounded-lg border-blue-400 shadow">{{ number_format($pair->price_diff * $capital / 100,1,'.',' ') }}</span>
                                </td>
                                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                    <ul class="grid gap-2">
                                        @foreach ($pair->prices as $price)
                                            <li class="flex items-center">

                                                @if($price->exchange->logo_url)
                                                    <img class="w-5 h-5 rounded-full mr-3"
                                                         src="{{ asset(Storage::url($price->exchange->logo_url)) }}"
                                                         alt="Rounded avatar">
                                                @else
                                                    <img class="w-5 h-5 rounded-full mr-3"
                                                         src="https://ui-avatars.com/api/?name={{ $price->exchange->name }}"
                                                         alt="No Logo">
                                                @endif

                                                <span
                                                    class="text-sm font-medium text-gray-900">
                                                        <a href="{{ $price->exchange->getTradeUrl($pair->symbol->base_currency, $pair->symbol->quote_currency)  }}"
                                                           target="_blank"
                                                           class="hover:text-primary-700">{{ $price->exchange_name }}  </a> - {{ $price->price_formatted }}

                                                    {!! $price->exchange->displayCurrency($pair->symbol->base_currency) !!}
                                                    </span>


                                            </li>
                                        @endforeach

                                    </ul>
                                </td>
                                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm font-medium text-gray-900">{{ $pair->price_diff }}%</span>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('symbol.info', $pair->symbol) }}"
                                       class="text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-4 lg:px-4 py-2 lg:py-2 mr-2 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800">{{ __('More...') }}</a>
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                   <div class="mt-6 px-6">
                       {!! $links !!}
                   </div>
                </div>
            </div>
        </div>
    </div>
</div>
