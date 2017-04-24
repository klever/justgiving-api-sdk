<?php

namespace Klever\JustGivingApiSdk\ResourceClients;


class SearchClient extends BaseClient
{
    protected $aliases = [
        'charity'    => 'CharitySearch',
        'event'      => 'EventSearch',
        'fundraiser' => 'FundraiserSearch',
        'inMemory'   => 'InMemorySearch',
        'team'       => 'TeamSearch',
    ];

    public function charity($searchTerms, $pageSize = 50, $pageNumber = 1)
    {
        return $this->get("charity/search?q=" . urlencode($searchTerms) . "&PageSize=" . $pageSize . "&PageNum=" . $pageNumber);
    }

    public function event($searchTerms, $pageSize = 50, $pageNumber = 1)
    {
        return $this->get("event/search?q=" . urlencode($searchTerms) . "&PageSize=" . $pageSize . "&PageNum=" . $pageNumber);
    }

    public function fundraiser($searchTerms, $charityId, $pageSize = 50, $pageNumber = 1)
    {
        return $this->get("fundraising/search?q=" . urlencode($searchTerms) . "&PageSize=" . $pageSize . "&PageNum=" . $pageNumber . "&charityId=" . $charityId);
    }

    public function inMemory($searchTerms, $pageSize = 50, $pageNumber = 1)
    {
        return $this->get("remember/search?q=" . urlencode($searchTerms) . "&PageSize=" . $pageSize . "&PageNum=" . $pageNumber);
    }

    public function team($teamShortName)
    {
        return $this->get("team/search?teamname=" . $teamShortName);
    }
}
