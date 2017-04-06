<?php

namespace Klever\JustGivingApiSdk\Clients;

use Klever\JustGivingApiSdk\Clients\Http\CurlWrapper;

class OneSearchApi extends ClientBase
{

    public $Parent;
    public $curlWrapper;

    public function __construct($justGivingApi)
    {
        $this->Parent = $justGivingApi;
        $this->curlWrapper = new CurlWrapper();
    }

    public function Index($searchTerm, $resultByIndex, $limit = 10)
    {
        $url = "onesearch?q=" . $searchTerm . "&i=" . $resultByIndex . "&limit=" . $limit;

        $json = $this->curlWrapper->Get($url);

        return json_decode($json);
    }
}
