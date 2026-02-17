<?php

namespace Konsulting\JustGivingApiSdk\Tests\ResourceClients;

class CountriesTest extends ResourceClientTestCase
{
    public function test_get_countries_return_countries()
    {
        $response = $this->client->countries->countries();

        $this->assertObjectHasProperty('countryCode', $response->getAttributes()[0]);
        $this->assertObjectHasProperty('name', $response->getAttributes()[0]);
    }
}
