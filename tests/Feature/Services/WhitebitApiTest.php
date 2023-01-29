<?php

namespace Tests\Feature\Services;

use App\Services\WhitebitApi;
use Tests\TestCase;


class WhitebitApiTest extends TestCase
{

    public function test_get_symbols()
    {
        $api = new WhitebitApi();
        $symbols = $api->get_symbols();
        $this->assertInstanceOf(\Illuminate\Support\Collection::class, $symbols);
    }

    public function test_get_currencies()
    {
        $api = new WhitebitApi();
        $currencies = $api->get_currencies();
        $this->assertInstanceOf(\Illuminate\Support\Collection::class, $currencies);
    }


}
