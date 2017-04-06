<?php

namespace Klever\JustGivingApiSdk\Clients;


class SearchApi extends ClientBase
{
    public function CharitySearch($searchTerms, $pageSize = 50, $pageNumber = 1)
    {
        $locationFormat = $this->Parent->baseUrl() . "charity/search?q=" . urlencode($searchTerms) . "&PageSize=" . $pageSize . "&PageNum=" . $pageNumber;
        $url = $this->BuildUrl($locationFormat);
        $json = $this->curlWrapper->Get($url, $this->BuildAuthenticationValue());

        return json_decode($json);
    }

    public function EventSearch($searchTerms, $pageSize = 50, $pageNumber = 1)
    {
        $locationFormat = $this->Parent->baseUrl() . "event/search?q=" . urlencode($searchTerms) . "&PageSize=" . $pageSize . "&PageNum=" . $pageNumber;
        $url = $this->BuildUrl($locationFormat);
        $json = $this->curlWrapper->Get($url);

        return json_decode($json);
    }

    public function FundraiserSearch($searchTerms, $charityId, $pageSize = 50, $pageNumber = 1)
    {
        $locationFormat = $this->Parent->baseUrl() . "fundraising/search?q=" . urlencode($searchTerms) . "&PageSize=" . $pageSize . "&PageNum=" . $pageNumber . "&charityId=" . $charityId;
        $url = $this->BuildUrl($locationFormat);
        $json = $this->curlWrapper->Get($url);

        return json_decode($json);
    }

    public function InMemorySearch($searchTerms, $pageSize = 50, $pageNumber = 1)
    {
        $locationFormat = $this->Parent->baseUrl() . "remember/search?q=" . urlencode($searchTerms) . "&PageSize=" . $pageSize . "&PageNum=" . $pageNumber;
        $url = $this->BuildUrl($locationFormat);
        $json = $this->curlWrapper->Get($url);

        return json_decode($json);
    }

    public function TeamSearch($teamShortName)
    {
        $locationFormat = $this->Parent->baseUrl() . "team/search?teamname=" . $teamShortName;
        $url = $this->BuildUrl($locationFormat);
        $json = $this->curlWrapper->Get($url);

        return json_decode($json);
    }
}
