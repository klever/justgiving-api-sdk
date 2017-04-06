<?php

namespace Klever\JustGivingApiSdk\Clients;

class CharityApi extends ClientBase
{


    public function Retrieve($charityId)
    {
        $url = "charity/" . $charityId;

        $json = $this->curlWrapper->Get($url, $this->BuildAuthenticationValue());

        return json_decode($json);
    }

    public function Authenticate($authenticateCharityAccountRequest)
    {
        $url = "charity/authenticate";

        $payload = json_encode($authenticateCharityAccountRequest);
        $json = $this->curlWrapper->PostAndGetResponse($url, "", $payload);

        return json_decode($json);
    }

    public function GetEventsByCharityId($charityId)
    {
        $url = "charity/" . $charityId . "/events";

        $json = $this->curlWrapper->Get($url);

        return json_decode($json);
    }

    public function GetDonations($charityId)
    {
        $url = "charity/" . $charityId . "/donations";

        $json = $this->curlWrapper->Get($url);

        return json_decode($json);
    }

    public function DeleteFundraisingPageAttribution($deleteFundraisingPageAttributionRequest)
    {
        $request = $deleteFundraisingPageAttributionRequest;
        $url = "charity/" . $request->charityId . "/pages/" . $request->pageShortName . "/attribution";

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
        $url = "charity/" . $request->charityId . "/pages/" . $request->pageShortName . "/attribution";

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
        $url = "charity/" . $request->charityId . "/pages/" . $request->pageShortName . "/attribution";

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
        $url = "charity/" . $request->charityId . "/pages/" . $request->pageShortName . "/attribution";

        $json = $this->curlWrapper->Get($url, $this->BuildAuthenticationValue());

        return json_decode($json);
    }

    public function Categories()
    {
        $url = "charity/categories";

        $json = $this->curlWrapper->Get($url);

        return json_decode($json);
    }
}
