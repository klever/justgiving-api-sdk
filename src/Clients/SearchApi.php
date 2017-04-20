<?php

namespace Klever\JustGivingApiSdk\Clients;


class SearchApi extends BaseClient
{
    public function CharitySearch($searchTerms, $pageSize = 50, $pageNumber = 1)
    {
        return $this->get("charity/search?q=" . urlencode($searchTerms) . "&PageSize=" . $pageSize . "&PageNum=" . $pageNumber);
    }

    public function EventSearch($searchTerms, $pageSize = 50, $pageNumber = 1)
    {
        return $this->get("event/search?q=" . urlencode($searchTerms) . "&PageSize=" . $pageSize . "&PageNum=" . $pageNumber);
    }

    public function FundraiserSearch($searchTerms, $charityId, $pageSize = 50, $pageNumber = 1)
    {
        return $this->get("fundraising/search?q=" . urlencode($searchTerms) . "&PageSize=" . $pageSize . "&PageNum=" . $pageNumber . "&charityId=" . $charityId);
    }

    public function InMemorySearch($searchTerms, $pageSize = 50, $pageNumber = 1)
    {
        return $this->get("remember/search?q=" . urlencode($searchTerms) . "&PageSize=" . $pageSize . "&PageNum=" . $pageNumber);
    }

    public function TeamSearch($teamShortName)
    {
        return $this->get("team/search?teamname=" . $teamShortName);
    }
}
