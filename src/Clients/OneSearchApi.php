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
        $locationFormat = $this->Parent->baseUrl() . "onesearch?q=" . $searchTerm . "&i=" . $resultByIndex . "&limit=" . $limit;
        $url = $this->BuildUrl($locationFormat);
        $json = $this->curlWrapper->Get($url);

        return json_decode($json);
    }
}
