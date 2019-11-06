<?php

namespace Konsulting\JustGivingApiSdk\ResourceClients;

use Konsulting\JustGivingApiSdk\ResourceClients\Models\RegisterCampaignRequest;

class CampaignClient extends BaseClient
{
    protected $aliases = [
        'registerFundraisingPage' => 'RegisterCampaignFundraisingPage',
        'retrieve'                => 'GetCampaignDetails',
        'pages'                   => 'GetPagesForCampaign',
        'create'                  => 'CreateCampaign',
        'getAllByCharityId'       => 'GetCampaignsByCharityId',
    ];

    public function retrieve($charityName, $campaignName)
    {
        return $this->get("campaigns/" . $charityName . "/" . $campaignName);
    }
    
    // Add support for v2 of the API to allow retrieval of newer campaigns
    public function retrieveBeta($campaignGUID)
    {
        return $this->get("campaign/". $campaignGUID);
    }


    /**
     * Test context account is not authorised to create a new campaign.
     *
     * @codeCoverageIgnore
     */
    public function create(RegisterCampaignRequest $registerCampaignRequest)
    {
        return $this->post('campaigns', $registerCampaignRequest);
    }

    public function pages($charityShortName, $campaignShortUrl)
    {
        return $this->get("campaigns/" . $charityShortName . "/" . $campaignShortUrl . "/pages");
    }

    public function getAllByCharityId($charityId)
    {
        return $this->get('campaigns/' . $charityId);
    }

    /**
     * Test context account is not authorised to create a new campaign.
     *
     * @codeCoverageIgnore
     */
    public function registerFundraisingPage($registerCampaignFundraisingPageRequest)
    {
        return $this->post('campaigns', $registerCampaignFundraisingPageRequest);
    }
}
