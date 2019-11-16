<?php

namespace Konsulting\JustGivingApiSdk\Tests\ResourceClients;

class DonationTest extends ResourceClientTestCase
{
    /** @test */
    public function it_retrieves_a_donation_by_id()
    {
        $response = $this->client->donation->getById(21303723);

        $this->assertNotNull($response->body->amount, 'Amount not present in body.');
        $this->assertEquals($response->body->currencyCode, "GBP");
        $this->assertEquals($response->body->status, "Accepted");
    }

    /** @test */
    public function it_gets_the_status_of_a_donation()
    {
        $response = $this->client->donation->getStatus(21303723);

        $this->assertObjectHasAttributes(['amount', 'donationId', 'donationRef', 'ref', 'status'], $response->body);
    }

    /** @test */
    public function it_gets_donation_details_by_a_third_party_reference()
    {
        $response = $this->client->donation->getDetailsByReference('1234-my-sdi-ref');

        $this->assertTrue(is_array($response->body->donations));
    }

    /** @test */
    public function it_gets_donation_totals_by_a_third_party_reference()
    {
        $response = $this->client->donation->getTotalByReference('1234-my-sdi-ref');

        $this->assertObjectHasAttributes(['CurrencyCode', 'DonationsTotal', 'NumberOfDonations', 'ThirdPartyReference', 'TotalEstimatedTaxReclaim'], $response->body);
    }
}
