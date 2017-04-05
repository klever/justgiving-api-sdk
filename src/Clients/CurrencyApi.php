<?php namespace Klever\JustGivingApiSdk\Clients;

use Klever\JustGivingApiSdk\Clients\Http\CurlWrapper;

include_once 'ClientBase.php';

class CurrencyApi extends ClientBase
{
    public $Parent;
    public $curlWrapper;

    public function __construct($justGivingApi)
    {
        $this->Parent = $justGivingApi;
        $this->curlWrapper = new CurlWrapper();
    }

    public function ValidCurrencies()
    {
        $locationFormat = $this->Parent->baseUrl() . "fundraising/currencies";
        $url = $this->BuildUrl($locationFormat);
        $json = $this->curlWrapper->Get($url);

        return json_decode($json);
    }
}
