<?php
namespace Klever\JustGivingApiSdk\Tests;
class CurrencyTest extends Base {
    public function testGetValidCurrencies_ReturnCurrencies() {
        $response = $this->client->Currency->ValidCurrencies();
        $this->assertNotNull($response);
    }
}
