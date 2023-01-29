<?php

namespace App\Services\Traits;

trait ExchangeUtilities
{
    function saveToJson($data, $filename){
        $path = storage_path('app/public/json/' . $filename . '.json');
        file_put_contents($path, json_encode($data));
    }
}
