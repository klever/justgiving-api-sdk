<?php

namespace Klever\JustGivingApiSdk\Clients;

class OneSearchApi extends BaseClient
{
    public function Index($searchTerm, $resultByIndex, $limit = 10)
    {
        $url = "onesearch?q=" . $searchTerm . "&i=" . $resultByIndex . "&limit=" . $limit;

        $json = $this->getContent($url);

        return json_decode($json);
    }
}
