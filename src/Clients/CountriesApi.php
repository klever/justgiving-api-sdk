<?php

namespace Klever\JustGivingApiSdk\Clients;

class CountriesApi extends ClientBase
{
    public function Countries()
    {
        $url = "countries";

        $json = $this->curlWrapper->Get($url);

        return json_decode($json);
    }
}
