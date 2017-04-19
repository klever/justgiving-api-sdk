<?php

namespace Klever\JustGivingApiSdk\Clients;

use Klever\JustGivingApiSdk\Clients\Http\HTTPResponse;

class CampaignApi extends ClientBase
{
    public function Retrieve($charityName, $campaignName)
    {
        return $this->get("campaigns/" . $charityName . "/" . $campaignName);
    }

    public function Create($campaignCreationRequest)
    {
        return $this->put('campaigns', $campaignCreationRequest);
    }

    public function PagesForCampaign($charityShortName, $campaignShortUrl)
    {
        return $this->get("campaigns/" . $charityShortName . "/" . $campaignShortUrl . "/pages");
    }

    public function CampaignsByCharityId($charityId)
    {
        return $this->get('campaigns/' . $charityId);
    }

    public function RegisterCampaignFundraisingPage($registerCampaignFundraisingPageRequest)
    {
        return $this->post('campaigns', $registerCampaignFundraisingPageRequest);
    }
}
