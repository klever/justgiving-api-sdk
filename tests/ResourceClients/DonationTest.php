<?php

namespace Klever\JustGivingApiSdk\Tests\ResourceClients;

use Klever\JustGivingApiSdk\Tests\Base;

class DonationTest extends Base
{
    /** @test */
    public function it_retrieves_a_donation_by_id()
    {
        $response = $this->client->donation->getById(21303723);

        $this->assertNotNull($response->amount);
        $this->assertEquals($response->currencyCode, "GBP");
        $this->assertEquals($response->status, "Accepted");
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

        $this->assertTrue(is_array($response->donations));
    }

    /** @test */
    public function it_gets_donation_totals_by_a_third_party_reference()
    {
        $response = $this->client->donation->getTotalByReference('1234-my-sdi-ref');

        $this->assertObjectHasAttributes(['CurrencyCode', 'DonationsTotal', 'NumberOfDonations', 'ThirdPartyReference', 'TotalEstimatedTaxReclaim'], $response->body);
    }
}
