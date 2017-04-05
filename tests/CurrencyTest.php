<?php

namespace Klever\JustGivingApiSdk\Tests;

class CurrencyTest extends Base
{
    /** @test */
    public function get_valid_currencies_return_currencies()
    {
        $response = $this->client->Currency->ValidCurrencies();
        $this->assertNotNull($response);
    }
}
