<?php

namespace Klever\JustGivingApiSdk\Tests;

class CurrencyTest extends Base
{
    /** @test */
    public function get_valid_currencies_return_currencies()
    {
        $response = $this->client->Currency->getValidCodes();

        $this->assertObjectHasAttribute('currencySymbol', $response->getAttributes()[0]);
        $this->assertObjectHasAttribute('currencyCode', $response->getAttributes()[0]);
        $this->assertObjectHasAttribute('description', $response->getAttributes()[0]);
    }
}
