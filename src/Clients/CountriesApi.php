<?php

namespace Klever\JustGivingApiSdk\Clients;

class CountriesApi extends ClientBase
{
    public function Countries()
    {
        $locationFormat = $this->Parent->baseUrl() . "countries";
        $url = $this->BuildUrl($locationFormat);
        $json = $this->curlWrapper->Get($url);

        return json_decode($json);
    }
}
