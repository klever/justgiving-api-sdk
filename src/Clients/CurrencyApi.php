<?php

namespace Klever\JustGivingApiSdk\Clients;

use Klever\JustGivingApiSdk\Clients\Http\CurlWrapper;

class CurrencyApi extends ClientBase
{
    public function ValidCurrencies()
    {
        $locationFormat = $this->Parent->baseUrl() . "fundraising/currencies";
        $url = $this->BuildUrl($locationFormat);
        $json = $this->curlWrapper->Get($url);

        return json_decode($json);
    }
}
