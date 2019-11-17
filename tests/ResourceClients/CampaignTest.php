<?php

namespace Konsulting\JustGivingApiSdk\Tests\ResourceClients;

class CampaignTest extends ResourceClientTestCase
{
    /** @test */
    public function it_retrieves_campaign_details_given_the_charity_and_campaign_names()
    {
        $charityName = "jgdemo";
        $campaignName = "testsandboxcampaign";
        $expectedCampaignPageName = "The name of my campaign";

        $response = $this->client->Campaign->retrieve($charityName, $campaignName);

        $this->assertTrue($response->existenceCheck(), implode("\n", $response->errors));
        $this->assertEquals($expectedCampaignPageName, $response->campaignPageName);
    }

    /** @test */
    public function it_retrieves_a_list_of_campaigns_given_a_charity_id()
    {
        $expectedCampaignPageName = "test";

        $response = $this->client->Campaign->getAllByCharityId('249335');

        $this->assertSuccessfulResponse($response);
        $this->assertEquals($expectedCampaignPageName, $response->body->campaignsDetails[0]->campaignPageName);
    }

    /** @test */
    public function it_retrieves_campaign_pages_when_given_a_charity_short_name_and_short_url()
    {
        $charityShortName = "porthospcf";
        $campaignShortUrl = "supportporthospcharity";

        $response = $this->client->Campaign->pages($charityShortName, $campaignShortUrl);

        $this->assertSuccessfulResponse($response);
        $this->assertTrue(is_array($response->fundraisingPages));
        $this->assertEquals($campaignShortUrl, $response->campaignShortUrl);
        $this->assertEquals($charityShortName, $response->charityShortName);
    }
}
