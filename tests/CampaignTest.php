<?php

namespace Klever\JustGivingApiSdk\Tests;

use Klever\JustGivingApiSdk\ResourceClients\Models\Assets\Image;
use Klever\JustGivingApiSdk\ResourceClients\Models\RegisterCampaignRequest;

class CampaignTest extends Base
{
    /** @test */
    public function it_retrieves_campaign_details_given_the_charity_and_campaign_names()
    {
        $charityName = "jgdemo";
        $campaignName = "testsandboxcampaign";
        $expectedCampaignPageName = "The name of my campaign";

        $response = $this->client->Campaign->retrieve($charityName, $campaignName);

        $this->assertTrue($response->existenceCheck());
        $this->assertEquals($expectedCampaignPageName, $response->campaignPageName);
    }

    /** @test */
    public function it_retrieves_a_list_of_campaigns_given_a_charity_id()
    {
        $expectedCampaignPageName = "The name of my campaign";

        $response = $this->client->Campaign->getAllByCharityId("2050");

        $this->assertEquals($response->body->campaignsDetails[0]->campaignPageName, $expectedCampaignPageName);
    }

    /** @test */
    public function it_retrieves_campaign_pages_when_given_a_charity_short_name_and_short_url()
    {
        $charityShortName = "jgdemo";
        $campaignShortUrl = "testsandboxcampaign";

        $response = $this->client->Campaign->pages($charityShortName, $campaignShortUrl);

        $this->assertTrue(is_array($response->fundraisingPages));
        $this->assertEquals($response->campaignShortUrl, $campaignShortUrl);
        $this->assertEquals($response->charityShortName, $charityShortName);
    }

    /** @test */
    public function it_creates_a_campaign()
    {
        $newCampaign = new RegisterCampaignRequest([
            'campaignUrl'             => 'a' . uniqid(),
            'campaignName'            => uniqid(),
            'campaignSummary'         => 'A summary of the campaign.',
            'campaignStory'           => 'My story',
            'campaignThankYouMessage' => 'Thank you.',
            'campaignCoverPhotos'     => [new Image([
                "Alt"     => "Test image",
                "Caption" => "Image that shows off some info about my campaign",
                "Title"   => "My test image",
                "Url"     => "https://upload.wikimedia.org/wikipedia/commons/c/c4/PM5544_with_non-PAL_signals.png"
            ])]
        ]);

        $response = $this->client->campaign->create($newCampaign);

        dd($response->getReasonPhrase(), $response->getHeaders());
    }
}
