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
        if ($this->Parent->Username != null && $this->Parent->Username != "") {
            $stringForEnc = $this->Parent->Username . ":" . $this->Parent->Password;

            return base64_encode($stringForEnc);
        }

        return "";
    }

    public function WriteLine($string)
    {
        echo $string . "<br/>";
    }
}
