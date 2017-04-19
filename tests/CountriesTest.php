<?php

namespace Klever\JustGivingApiSdk\Tests;

class CountriesTest extends Base
{
    public function testGetCountries_ReturnCountries()
    {
        $response = $this->client->countries->Countries();

        $this->assertObjectHasAttribute('countryCode', $response->getAttributes()[0]);
        $this->assertObjectHasAttribute('name', $response->getAttributes()[0]);
    }
}
