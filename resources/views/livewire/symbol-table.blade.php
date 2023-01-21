<div>
    <div class="flex flex-col">
        <div class="overflow-x-auto sm:mx-0.5 lg:mx-0.5">
            <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
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
