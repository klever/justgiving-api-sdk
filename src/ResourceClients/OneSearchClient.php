<?php

namespace Klever\JustGivingApiSdk\ResourceClients;

class OneSearchClient extends BaseClient
{
    protected $aliases = [
        'index' => 'OneSearchIndex',
    ];

    public function index($searchTerm, $resultByIndex = '', $limit = 10)
    {
        // TODO: implement other query parameters
        return $this->get("onesearch?q=" . $searchTerm . "&i=" . $resultByIndex . "&limit=" . $limit);
    }
}
