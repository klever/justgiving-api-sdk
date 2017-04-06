<?php

namespace Klever\JustGivingApiSdk\Clients;


class SearchApi extends ClientBase
{
    public function CharitySearch($searchTerms, $pageSize = 50, $pageNumber = 1)
    {
        $url = "charity/search?q=" . urlencode($searchTerms) . "&PageSize=" . $pageSize . "&PageNum=" . $pageNumber;

        $json = $this->getContent($url);

        return json_decode($json);
    }

    public function EventSearch($searchTerms, $pageSize = 50, $pageNumber = 1)
    {
        $url = "event/search?q=" . urlencode($searchTerms) . "&PageSize=" . $pageSize . "&PageNum=" . $pageNumber;

        $json = $this->getContent($url);

        return json_decode($json);
    }

    public function FundraiserSearch($searchTerms, $charityId, $pageSize = 50, $pageNumber = 1)
    {
        $url = "fundraising/search?q=" . urlencode($searchTerms) . "&PageSize=" . $pageSize . "&PageNum=" . $pageNumber . "&charityId=" . $charityId;

        $json = $this->getContent($url);

        return json_decode($json);
    }

    public function InMemorySearch($searchTerms, $pageSize = 50, $pageNumber = 1)
    {
        $url = "remember/search?q=" . urlencode($searchTerms) . "&PageSize=" . $pageSize . "&PageNum=" . $pageNumber;

        $json = $this->getContent($url);

        return json_decode($json);
    }

    public function TeamSearch($teamShortName)
    {
        $url = "team/search?teamname=" . $teamShortName;

        $json = $this->getContent($url);

        return json_decode($json);
    }
}
