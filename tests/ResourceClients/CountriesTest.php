<?php

namespace Konsulting\JustGivingApiSdk\Tests\ResourceClients;

class CountriesTest extends ResourceClientTestCase
{
    public function testGetCountries_ReturnCountries()
    {
        $response = $this->client->countries->countries();

        $this->assertObjectHasAttribute('countryCode', $response->getAttributes()[0]);
        $this->assertObjectHasAttribute('name', $response->getAttributes()[0]);
    }
}
