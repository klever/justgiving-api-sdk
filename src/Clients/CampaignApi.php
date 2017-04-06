<?php

namespace Klever\JustGivingApiSdk\Clients;

use Klever\JustGivingApiSdk\Clients\Http\HTTPResponse;

class CampaignApi extends ClientBase
{
    public function Retrieve($charityName, $campaignName)
    {
        $url = "campaigns/" . $charityName . "/" . $campaignName;

        $json = $this->getContent($url);

        return json_decode($json);
    }

    public function RetrieveV2($charityName, $campaignName)
    {
        $httpResponse = new HTTPResponse();
        $url = "campaigns/" . $charityName . "/" . $campaignName;

        $result = $this->curlWrapper->GetV2($url);
        $httpResponse->bodyResponse = json_decode($result->bodyResponse);
        $httpResponse->httpStatusCode = $result->httpStatusCode;

        return $httpResponse;
    }

    public function Create($campaignCreationRequest)
    {
        $url = "campaigns";

        $payload = json_encode($campaignCreationRequest);
        $json = $this->curlWrapper->Put($url, $payload);

        return json_decode($json);
    }

    public function CreateV2($campaignCreationRequest)
    {
        $httpResponse = new HTTPResponse();
        $url = "campaigns";

        $payload = json_encode($campaignCreationRequest);
        $result = $this->curlWrapper->PutV2($url, $payload);
        $httpResponse->bodyResponse = json_decode($result->bodyResponse);
        $httpResponse->httpStatusCode = $result->httpStatusCode;

        return $httpResponse;
    }

    public function PagesForCampaign($charityShortName, $campaignShortUrl)
    {
        $httpResponse = new HTTPResponse();
        $url = "campaigns/" . $charityShortName . "/" . $campaignShortUrl . "/pages";

        $result = $this->curlWrapper->GetV2($url);
        $httpResponse->bodyResponse = json_decode($result->bodyResponse);
        $httpResponse->httpStatusCode = $result->httpStatusCode;

        return $httpResponse;
    }

    public function CampaignsByCharityId($charityId)
    {
        $httpResponse = new HTTPResponse();
        $url = "campaigns/" . $charityId;

        $result = $this->curlWrapper->GetV2($url);
        $httpResponse->bodyResponse = json_decode($result->bodyResponse);
        $httpResponse->httpStatusCode = $result->httpStatusCode;

        return $httpResponse;
    }

    public function RegisterCampaignFundraisingPage($registerCampaignFundraisingPageRequest)
    {
        $httpResponse = new HTTPResponse();
        $url = "campaigns";

        $payload = json_encode($registerCampaignFundraisingPageRequest);
        $result = $this->curlWrapper->PostV2($url, $payload);
        $httpResponse->bodyResponse = json_decode($result->bodyResponse);
        $httpResponse->httpStatusCode = $result->httpStatusCode;

        return $httpResponse;
    }
}
