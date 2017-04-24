<?php

namespace Klever\JustGivingApiSdk\ResourceClients;

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

    public function create($campaignCreationRequest)
    {
        return $this->put('campaigns', $campaignCreationRequest);
    }

    public function pages($charityShortName, $campaignShortUrl)
    {
        return $this->get("campaigns/" . $charityShortName . "/" . $campaignShortUrl . "/pages");
    }

    public function getAllByCharityId($charityId)
    {
        return $this->get('campaigns/' . $charityId);
    }

    public function registerFundraisingPage($registerCampaignFundraisingPageRequest)
    {
        return $this->post('campaigns', $registerCampaignFundraisingPageRequest);
    }
}
