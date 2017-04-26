<?php

namespace Klever\JustGivingApiSdk\ResourceClients;

use Klever\JustGivingApiSdk\ResourceClients\Models\RegisterCampaignRequest;

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
