<?php namespace Klever\JustGivingApiSdk\Clients;

include_once 'ClientBase.php';
include_once 'Http/CurlWrapper.php';

class CharityApi extends ClientBase
{


    public function Retrieve($charityId)
    {
        $locationFormat = $this->Parent->baseUrl() . "charity/" . $charityId;
        $url = $this->BuildUrl($locationFormat);
        $json = $this->curlWrapper->Get($url, $this->BuildAuthenticationValue());

        return json_decode($json);
    }

    public function Authenticate($authenticateCharityAccountRequest)
    {
        $locationFormat = $this->Parent->baseUrl() . "charity/authenticate";
        $url = $this->BuildUrl($locationFormat);
        $payload = json_encode($authenticateCharityAccountRequest);
        $json = $this->curlWrapper->PostAndGetResponse($url, "", $payload);

        return json_decode($json);
    }

    public function GetEventsByCharityId($charityId)
    {
        $locationFormat = $this->Parent->baseUrl() . "charity/" . $charityId . "/events";
        $url = $this->BuildUrl($locationFormat);
        $json = $this->curlWrapper->Get($url);

        return json_decode($json);
    }

    public function GetDonations($charityId)
    {
        $locationFormat = $this->Parent->baseUrl() . "charity/" . $charityId . "/donations";
        $url = $this->BuildUrl($locationFormat);
        $json = $this->curlWrapper->Get($url);

        return json_decode($json);
    }

    public function DeleteFundraisingPageAttribution($deleteFundraisingPageAttributionRequest)
    {
        $request = $deleteFundraisingPageAttributionRequest;
        $locationFormat = $this->Parent->baseUrl() . "charity/" . $request->charityId . "/pages/" . $request->pageShortName . "/attribution";
        $url = $this->BuildUrl($locationFormat);
        $json = $this->curlWrapper->Delete($url);

        if ($json['http_code'] == 201) {
            return true;
        } else {
            return false;
        }
    }

    public function UpdateFundraisingPageAttribution($fundraisingPageAttributionRequest, $updateFundraisingPageAttributionRequest)
    {
        $request = $fundraisingPageAttributionRequest;
        $locationFormat = $this->Parent->baseUrl() . "charity/" . $request->charityId . "/pages/" . $request->pageShortName . "/attribution";
        $url = $this->BuildUrl($locationFormat);
        $payload = json_encode($updateFundraisingPageAttributionRequest);
        $json = $this->curlWrapper->Put($url, $this->BuildAuthenticationValue(), $payload, true);
        if ($json['http_code'] == 201) {
            return true;
        } else {
            return false;
        }
    }

    public function AppendFundraisingPageAttribution($fundraisingPageAttributionRequest, $updateFundraisingPageAttributionRequest)
    {
        $request = $fundraisingPageAttributionRequest;
        $locationFormat = $this->Parent->baseUrl() . "charity/" . $request->charityId . "/pages/" . $request->pageShortName . "/attribution";
        $url = $this->BuildUrl($locationFormat);
        $payload = json_encode($updateFundraisingPageAttributionRequest);
        $json = $this->curlWrapper->Post($url, $this->BuildAuthenticationValue(), $payload);
        if ($json['http_code'] == 201) {
            return true;
        } else {
            return false;
        }
    }

    public function GetFundraisingPageAttribution($fundraisingPageAttributionRequest, $updateFundraisingPageAttributionRequest)
    {
        $request = $fundraisingPageAttributionRequest;
        $locationFormat = $this->Parent->baseUrl() . "charity/" . $request->charityId . "/pages/" . $request->pageShortName . "/attribution";
        $url = $this->BuildUrl($locationFormat);
        $json = $this->curlWrapper->Get($url, $this->BuildAuthenticationValue());

        return json_decode($json);
    }

    public function Categories()
    {
        $locationFormat = $this->Parent->baseUrl() . "charity/categories";
        $url = $this->BuildUrl($locationFormat);
        $json = $this->curlWrapper->Get($url);

        return json_decode($json);
    }
}
