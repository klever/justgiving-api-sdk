<?php

namespace Konsulting\JustGivingApiSdk\Tests\ResourceClients;

class CountriesTest extends ResourceClientTestCase
{
    public function testGetCountries_ReturnCountries()
    {
        $response = $this->client->countries->countries();

        $this->assertObjectHasProperty('countryCode', $response->getAttributes()[0]);
        $this->assertObjectHasProperty('name', $response->getAttributes()[0]);
    }
}
