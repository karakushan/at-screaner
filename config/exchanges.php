<?php

return [
    'bybit' => [
        'api_key' => env('BYBIT_API_KEY'),
        'api_secret' => env('BYBIT_API_SECRET'),
        'base_url' => 'https://api.bybit.com',
    ],
    'whitebit' => [
        'api_key' => env('WHITEBIT_API_KEY'),
        'api_secret' => env('WHITEBIT_API_SECRET'),
        'base_url' => 'https://whitebit.com',
    ],
];
