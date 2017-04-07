<?php

namespace Klever\JustGivingApiSdk\Tests;

class CurrencyTest extends Base
{
    /** @test */
    public function get_valid_currencies_return_currencies()
    {
        $response = $this->client->Currency->ValidCurrencies()->getBodyAsObject();

        $this->assertObjectHasAttribute('currencySymbol', $response[0]);
        $this->assertObjectHasAttribute('currencyCode', $response[0]);
        $this->assertObjectHasAttribute('description', $response[0]);
    }
}
