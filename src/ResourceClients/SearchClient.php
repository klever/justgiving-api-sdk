<?php

namespace Konsulting\JustGivingApiSdk\ResourceClients;


use Konsulting\JustGivingApiSdk\ResourceClients\Models\SearchInMemoryRequest;
use Konsulting\JustGivingApiSdk\ResourceClients\Models\SearchTeamRequest;

class SearchClient extends BaseClient
{
    const DEFAULT_PAGE_SIZE = 50;

    protected $aliases = [
        'charity'    => 'CharitySearch',
        'event'      => 'EventSearch',
        'fundraiser' => 'FundraiserSearch',
        'inMemory'   => 'InMemorySearch',
        'team'       => 'TeamSearch',
    ];

    public function charity($searchTerms, $pageSize = self::DEFAULT_PAGE_SIZE, $pageNumber = 0)
    {
        return $this->get("charity/search?q=" . urlencode($searchTerms) . "&PageSize=" . $pageSize . "&page=" . $pageNumber);
    }

    public function event($searchTerms, $pageSize = self::DEFAULT_PAGE_SIZE, $pageNumber = 0)
    {
        return $this->get("event/search?q=" . urlencode($searchTerms) . "&PageSize=" . $pageSize . "&page=" . $pageNumber);
    }

    public function fundraiser($searchTerms, $charityId, $pageSize = self::DEFAULT_PAGE_SIZE, $pageNumber = 0)
    {
        return $this->get("fundraising/search?q=" . urlencode($searchTerms) . "&PageSize=" . $pageSize . "&page=" . $pageNumber . "&charityId=" . $charityId);
    }

    public function inMemory(SearchInMemoryRequest $searchRequest, $pageSize = self::DEFAULT_PAGE_SIZE, $pageNumber = 0)
    {
        return $this->get("remember/search?" . http_build_query($searchRequest->getAttributes()) . "&PageSize=" . $pageSize . "&page=" . $pageNumber);
    }

    public function team(SearchTeamRequest $searchRequest, $pageSize = self::DEFAULT_PAGE_SIZE, $pageNumber = 0)
    {
        return $this->get("team/search?" . http_build_query($searchRequest->getAttributes()) . "&PageSize=" . $pageSize . "&page=" . $pageNumber);
    }
}
