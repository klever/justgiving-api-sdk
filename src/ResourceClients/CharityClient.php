<?php

namespace Klever\JustGivingApiSdk\ResourceClients;

class CharityClient extends BaseClient
{
    protected $aliases = [
        'getById'                          => 'GetCharityById',
        'authenticate'                     => 'AuthenticateCharityAccount',
        'getEventsByCharityId'             => 'GetEventsByCharityId',
        'getDonations'                     => 'GetCharityDonations',
        'deleteFundraisingPageAttribution' => 'CharityDeleteFundraisingPageAttribution',
        'updateFundraisingPageAttribution' => 'CharityUpdateFundraisingPageAttribution',
        'appendFundraisingPageAttribution' => 'CharityAppendToFundraisingPageAttribution',
        'getFundraisingPageAttribution'    => 'CharityGetFundraisingPageAttribution',
        'categories'                       => 'GetCharityCategories',
    ];

    public function getById($charityId)
    {
        return $this->get("charity/" . $charityId);
    }

    public function authenticate($authenticateCharityAccountRequest)
    {
        return $this->post("charity/authenticate", $authenticateCharityAccountRequest);
    }

    public function getEventsByCharityId($charityId)
    {
        return $this->get("charity/" . $charityId . "/events");
    }

    public function getDonations($charityId)
    {
        return $this->get("charity/" . $charityId . "/donations");
    }

    public function deleteFundraisingPageAttribution($deleteFundraisingPageAttributionRequest)
    {
        $request = $deleteFundraisingPageAttributionRequest;
        $url = "charity/" . $request->charityId . "/pages/" . $request->pageShortName . "/attribution";

        return $this->delete($url);
    }

    public function updateFundraisingPageAttribution($fundraisingPageAttributionRequest, $updateFundraisingPageAttributionRequest)
    {
        $request = $fundraisingPageAttributionRequest;
        $url = "charity/" . $request->charityId . "/pages/" . $request->pageShortName . "/attribution";

        return $this->put($url, $updateFundraisingPageAttributionRequest);
    }

    public function appendFundraisingPageAttribution($fundraisingPageAttributionRequest, $updateFundraisingPageAttributionRequest)
    {
        $request = $fundraisingPageAttributionRequest;
        $url = "charity/" . $request->charityId . "/pages/" . $request->pageShortName . "/attribution";

        $json = $this->Post($url, $updateFundraisingPageAttributionRequest);
    }

    public function getFundraisingPageAttribution($fundraisingPageAttributionRequest, $updateFundraisingPageAttributionRequest)
    {
        $request = $fundraisingPageAttributionRequest;

        return $this->get("charity/" . $request->charityId . "/pages/" . $request->pageShortName . "/attribution");
    }

    public function categories()
    {
        return $this->get("charity/categories");
    }
}
