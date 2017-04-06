<?php

namespace Klever\JustGivingApiSdk\Clients;

use Klever\JustGivingApiSdk\Clients\Http\CurlWrapper;

class ClientBase
{
    public $debug;
    public $Parent;
    public $curlWrapper;

    public function __construct($httpClient, $justGivingApi)
    {
        $this->Parent = $justGivingApi;
        $this->curlWrapper = $httpClient;
        $this->debug = false;
    }

    public function BuildAuthenticationValue()
    {
        return empty($this->Parent->Username)
            ? ''
            : base64_encode($this->Parent->Username . ":" . $this->Parent->Password);
    }
}
