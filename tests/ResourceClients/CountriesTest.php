<?php

namespace Klever\JustGivingApiSdk\Tests\ResourceClients;

use Klever\JustGivingApiSdk\Tests\Base;

class CountriesTest extends Base
{
    public function testGetCountries_ReturnCountries()
    {
        $response = $this->client->countries->countries();

        $this->assertObjectHasAttribute('countryCode', $response->getAttributes()[0]);
        $this->assertObjectHasAttribute('name', $response->getAttributes()[0]);
    }
}
