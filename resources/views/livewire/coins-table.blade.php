<div>

    <div class="flex flex-col">
        <div class="overflow-x-auto sm:mx-0.5 lg:mx-0.5">
            <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
                <form action="" class="grid grid-cols-8 gap-2">
                    <div class="mb-6">
                        <label for="min_spread" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('Минимальный спред %') }}</label>
                        <input type="number" wire:model="min_spread" id="min_spread" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                    </div>
                    <div class="mb-6">
                        <label for="max_spread" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('Максимальный спред %') }}</label>
                        <input type="number" wire:model="max_spread" id="min_spread" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                    </div>
                    <div class="mb-6">
                        <label for="quote_asset"
                               class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('Quote Asset') }}</label>
                        <select id="quote_asset"
                                wire:model="quote_asset"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option selected>{{ __('Select') }}</option>
                            @foreach($quote_assets as $quote_asset)
                                <option value="{{ $quote_asset }}">{{ $quote_asset }}</option>
                            @endforeach
                        </select></div>
                    <div class="mb-6">
                        <label for="capital" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('Стартовый капитал') }}</label>
                        <input type="number" wire:model="capital" id="capital" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="name@flowbite.com" required>
                    </div>
                </form>
                <div class="overflow-hidden">
                    <table class="min-w-full">
                        <thead class="bg-gray-200 border-b">
                        <tr>
                            <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                {{ __("ID") }}
                            </th>
                            <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                {{ __("Символ") }}
                            </th>
                            <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                {{ __('Ціни') }}
                            </th>
                            <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                {{ __('Спред') }}
                            </th>
                            <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                {{ __('Прибыль') }}
                            </th>
                        </tr>
                        </thead>
                        <tbody wire:poll.5s>
                        @foreach ($symbols as $name=>$symbol)
                            <tr class="bg-white border-b transition duration-300 ease-in-out hover:bg-gray-100">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $symbol->id }} </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $symbol->name }} </td>
                                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                    <ul>
                                        @foreach ($symbol->prices as $price)
                                                <?php
                                                $links = [
                                                    'binance' => 'https://www.binance.com/en/trade/%s_%s?theme=dark&type=spot',
                                                    'bybit' => 'https://www.bybit.com/uk-UA/trade/spot/%s/%s',
                                                    'whitebit' => 'https://whitebit.com/ua/trade/%s-%s?tab=positions&type=spot',
                                                    'gate' => 'https://www.gate.io/trade/%s_%s',
                                                ];
                                                ?>
                                            <li class="flex">
                                                    <span
                                                        class="text-sm font-medium text-gray-900">{{ $price->exchange_name }} - {{ $price->price_formatted }}</span>
                                                <a href="{{ sprintf($links[$price->exchange->slug], $symbol->base_currency, $symbol->quote_currency) }}"
                                                   target="_blank" class="w-4 flex ml-2">
                                                    <svg fill="none" stroke="currentColor" stroke-width="1.5"
                                                         viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                                                         aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244"></path>
                                                    </svg>
                                                </a>

                                            </li>
                                        @endforeach

                                    </ul>
                                </td>
                                <td>
                                    <span class="text-sm font-medium text-gray-900">{{ $symbol->spread }}%</span>
                                </td>
                                <td>
                                    <span class="text-sm font-medium text-gray-900">{{ $symbol->spread * $capital / 100 }}</span>
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
