<?php

namespace Konsulting\JustGivingApiSdk\Tests\ResourceClients;

use PHPUnit\Framework\Attributes\Test;

class CurrencyTest extends ResourceClientTestCase
{
    #[Test]
    public function get_valid_currencies_return_currencies()
    {
        $response = $this->client->Currency->getValidCodes();

        $this->assertObjectHasProperty('currencySymbol', $response->getAttributes()[0]);
        $this->assertObjectHasProperty('currencyCode', $response->getAttributes()[0]);
        $this->assertObjectHasProperty('description', $response->getAttributes()[0]);
    }
}
