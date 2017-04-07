<?php

namespace Klever\JustGivingApiSdk\Tests;

class CountriesTest extends Base
{
    public function testGetCountries_ReturnCountries()
    {
        $response = $this->client->Countries->Countries()->getBodyAsObject();

        dd($response);
        $this->assertNotNull($response);
        $this->assertObjectHasAttribute('countryCode', $response[0]);
        $this->assertObjectHasAttribute('name', $response[0]);
    }
}
