<div>
    <div class="flex flex-col">
        <div class="overflow-x-auto sm:mx-0.5 lg:mx-0.5">
            <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
                <div class="flex justify-between items-center">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">{{ __('Символ :base/:quote',['base'=>$symbol->base_currency,'quote'=>$symbol->quote_currency])  }}</h1>
                    <a href="{{ route('home') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">{{ __('Go to home') }}</a>
                </div>
                <form action="" class="grid grid-cols-8 gap-2">
                    <div class="mb-6">
                        <label for="capital"
                               class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('Стартовый капитал') }}</label>
                        <div class="flex items-center">
                            <input type="number" wire:model="capital" id="capital"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   placeholder="name@flowbite.com" required>
                            <div class="ml-3 whitespace-nowrap font-medium">
                                @if($symbol)
                                    {{ __("Profit") }}: {{ $symbol->spread * $capital / 100 }}
                                @endif
                            </div>
                        </div>


                    </div>

                </form>
                <div class="overflow-hidden">
                    <table class="min-w-full">
                        <thead class="bg-gray-200 border-b">
                        <tr>
                            <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                {{ __("Exchange") }}
                            </th>
                            <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                {{ __("Price") }}
                            </th>
                            <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                {{ __("Blockchain/Network") }}
                            </th>
                        </tr>
                        </thead>
                        <tbody wire:poll.5s>

                        @if($symbol && $symbol->prices)
                            @forelse($symbol->prices as $price)
                                <tr class="bg-white border-b">
                                    <td class="px-6 py-4 text-sm text-gray-900">

                                        <a href="{{ $price->exchange->getTradeUrl($symbol->base_currency, $symbol->quote_currency)  }}"
                                           target="_blank">
                                            {{ $price->exchange->name }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        {{ $price->price_formatted }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        none
                                    </td>
                                </tr>
                            @empty
                                <tr class="bg-white border-b">
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        {{ __("No prices found") }}
                                    </td>
                                </tr>
                            @endforelse
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
