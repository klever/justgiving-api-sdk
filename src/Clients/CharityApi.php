<?php

namespace Klever\JustGivingApiSdk\Clients;

class CharityApi extends ClientBase
{
    public function Retrieve($charityId)
    {
        return $this->get("charity/" . $charityId);
    }

    public function Authenticate($authenticateCharityAccountRequest)
    {
        return $this->post("charity/authenticate", $authenticateCharityAccountRequest);
    }

    public function GetEventsByCharityId($charityId)
    {
        return $this->get("charity/" . $charityId . "/events");
    }

    public function GetDonations($charityId)
    {
        return $this->get("charity/" . $charityId . "/donations");
    }

    public function DeleteFundraisingPageAttribution($deleteFundraisingPageAttributionRequest)
    {
        $request = $deleteFundraisingPageAttributionRequest;
        $url = "charity/" . $request->charityId . "/pages/" . $request->pageShortName . "/attribution";

        return $this->delete($url)->wasSuccessful();
    }

    public function UpdateFundraisingPageAttribution($fundraisingPageAttributionRequest, $updateFundraisingPageAttributionRequest)
    {
        $request = $fundraisingPageAttributionRequest;
        $url = "charity/" . $request->charityId . "/pages/" . $request->pageShortName . "/attribution";

        return $this->put($url, $updateFundraisingPageAttributionRequest)->wasSuccessful();
    }

    public function AppendFundraisingPageAttribution($fundraisingPageAttributionRequest, $updateFundraisingPageAttributionRequest)
    {
        $request = $fundraisingPageAttributionRequest;
        $url = "charity/" . $request->charityId . "/pages/" . $request->pageShortName . "/attribution";

        $json = $this->Post($url, $updateFundraisingPageAttributionRequest)->wasSuccessful();
    }

    public function GetFundraisingPageAttribution($fundraisingPageAttributionRequest, $updateFundraisingPageAttributionRequest)
    {
        $request = $fundraisingPageAttributionRequest;

        return $this->getContent("charity/" . $request->charityId . "/pages/" . $request->pageShortName . "/attribution");
    }

    public function Categories()
    {
        return $this->get("charity/categories");
    }
}
