<?php

namespace Klever\JustGivingApiSdk\Tests;

class CharityTest extends Base
{
    public function testRetrieve_WhenSuppliedWithValidCharityId_RetrievesCharity()
    {
        $response = $this->client->Charity->Retrieve(2050)->getBodyAsObject();

        $this->assertEquals('The Demo Charity1', $response->name);
    }

    public function testGetEventsByCharityId_WhenSuppliedCorrectCharityId_ReturnEvents()
    {
        $response = $this->client->Charity->GetEventsByCharityId(2050)->getBodyAsObject();

        $this->assertNotNull($response);
        $this->assertNotNull($response->events);
    }

    public function testGetDonations_WhenSuppliedCorrectCharityId_ReturnDonations()
    {
        $response = $this->client->Charity->GetDonations(2050)->getBodyAsObject()->donations;

        $this->assertObjectHasAttribute('amount', $response[0]);
        $this->assertObjectHasAttribute('currencyCode', $response[0]);
    }

    public function testGetCategories_ReturnCategories()
    {
        $response = $this->client->Charity->Categories()->getBodyAsObject();

        $this->assertObjectHasAttribute('category', $response[0]);
        $this->assertObjectHasAttribute('id', $response[0]);
    }
}
