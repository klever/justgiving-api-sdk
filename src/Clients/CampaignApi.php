<?php

namespace Klever\JustGivingApiSdk\Clients;

use Klever\JustGivingApiSdk\Clients\Http\HTTPResponse;

class CampaignApi extends ClientBase
{
    public function Retrieve($charityName, $campaignName)
    {
        $locationFormat = $this->Parent->baseUrl() . "campaigns/" . $charityName . "/" . $campaignName;
        $url = $this->BuildUrl($locationFormat);
        $json = $this->curlWrapper->Get($url, $this->BuildAuthenticationValue());

        return json_decode($json);
    }

    public function RetrieveV2($charityName, $campaignName)
    {
        $httpResponse = new HTTPResponse();
        $locationFormat = $this->Parent->baseUrl() . "campaigns/" . $charityName . "/" . $campaignName;
        $url = $this->BuildUrl($locationFormat);
        $result = $this->curlWrapper->GetV2($url, $this->BuildAuthenticationValue());
        $httpResponse->bodyResponse = json_decode($result->bodyResponse);
        $httpResponse->httpStatusCode = $result->httpStatusCode;

        return $httpResponse;
    }

    public function Create($campaignCreationRequest)
    {
        $locationFormat = $this->Parent->baseUrl() . "campaigns";
        $url = $this->BuildUrl($locationFormat);
        $payload = json_encode($campaignCreationRequest);
        $json = $this->curlWrapper->Put($url, $this->BuildAuthenticationValue(), $payload);

        return json_decode($json);
    }

    public function CreateV2($campaignCreationRequest)
    {
        $httpResponse = new HTTPResponse();
        $locationFormat = $this->Parent->baseUrl() . "campaigns";
        $url = $this->BuildUrl($locationFormat);
        $payload = json_encode($campaignCreationRequest);
        $result = $this->curlWrapper->PutV2($url, $this->BuildAuthenticationValue(), $payload);
        $httpResponse->bodyResponse = json_decode($result->bodyResponse);
        $httpResponse->httpStatusCode = $result->httpStatusCode;

        return $httpResponse;
    }

    public function PagesForCampaign($charityShortName, $campaignShortUrl)
    {
        $httpResponse = new HTTPResponse();
        $locationFormat = $this->Parent->baseUrl() . "campaigns/" . $charityShortName . "/" . $campaignShortUrl . "/pages";
        $url = $this->BuildUrl($locationFormat);
        $result = $this->curlWrapper->GetV2($url, $this->BuildAuthenticationValue());
        $httpResponse->bodyResponse = json_decode($result->bodyResponse);
        $httpResponse->httpStatusCode = $result->httpStatusCode;

        return $httpResponse;
    }

    public function CampaignsByCharityId($charityId)
    {
        $httpResponse = new HTTPResponse();
        $locationFormat = $this->Parent->baseUrl() . "campaigns/" . $charityId;
        $url = $this->BuildUrl($locationFormat);
        $result = $this->curlWrapper->GetV2($url, $this->BuildAuthenticationValue());
        $httpResponse->bodyResponse = json_decode($result->bodyResponse);
        $httpResponse->httpStatusCode = $result->httpStatusCode;

        return $httpResponse;
    }

    public function RegisterCampaignFundraisingPage($registerCampaignFundraisingPageRequest)
    {
        $httpResponse = new HTTPResponse();
        $locationFormat = $this->Parent->baseUrl() . "campaigns";
        $url = $this->BuildUrl($locationFormat);
        $payload = json_encode($registerCampaignFundraisingPageRequest);
        $result = $this->curlWrapper->PostV2($url, $this->BuildAuthenticationValue(), $payload);
        $httpResponse->bodyResponse = json_decode($result->bodyResponse);
        $httpResponse->httpStatusCode = $result->httpStatusCode;

        return $httpResponse;
    }
}
