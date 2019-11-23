<?php

namespace Konsulting\JustGivingApiSdk\ResourceClients;

use Konsulting\JustGivingApiSdk\ResourceClients\Models\AuthenticateCharityAccountRequest;
use Konsulting\JustGivingApiSdk\ResourceClients\Models\UpdateFundraisingPageAttributionRequest;

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

    public function authenticate(AuthenticateCharityAccountRequest $authenticateRequest)
    {
        return $this->post("charity/authenticate", $authenticateRequest);
    }

    public function getEventsByCharityId($charityId)
    {
        return $this->get("charity/" . $charityId . "/events");
    }

    public function getDonations($charityId)
    {
        return $this->get("charity/" . $charityId . "/donations");
    }

    // Test account does not have permission to edit charity fundraising pages.
    // @codeCoverageIgnoreStart

    public function deleteFundraisingPageAttribution($charityId, $pageShortName)
    {
        return $this->delete("charity/" . $charityId . "/pages/" . $pageShortName . "/attribution");
    }

    public function updateFundraisingPageAttribution(
        $charityId,
        $pageShortName,
        UpdateFundraisingPageAttributionRequest $updateRequest
    ) {
        return $this->put("charity/" . $charityId . "/pages/" . $pageShortName . "/attribution", $updateRequest);
    }

    public function appendFundraisingPageAttribution(
        $charityId,
        $pageShortName,
        UpdateFundraisingPageAttributionRequest $updateRequest
    ) {
        return $this->Post("charity/" . $charityId . "/pages/" . $pageShortName . "/attribution", $updateRequest);
    }

    public function getFundraisingPageAttribution($charityId, $pageShortName)
    {
        return $this->get("charity/" . $charityId . "/pages/" . $pageShortName . "/attribution");
    }

    // @codeCoverageIgnoreEnd

    public function categories()
    {
        return $this->get("charity/categories");
    }
}
