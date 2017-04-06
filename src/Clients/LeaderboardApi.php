<?php

namespace Klever\JustGivingApiSdk\Clients;
use Klever\JustGivingApiSdk\Clients\Http\CurlWrapper;
use Klever\JustGivingApiSdk\Clients\Http\HTTPResponse;

class LeaderboardApi extends ClientBase
{
    public function GetCharityLeaderboard($charityId)
    {
        $httpResponse = new HTTPResponse();
        $locationFormat = $this->Parent->baseUrl() . "charity/" . $charityId . "/leaderboard";
        $url = $this->BuildUrl($locationFormat);
        $result = $this->curlWrapper->GetV2($url, $this->BuildAuthenticationValue());
        $httpResponse->bodyResponse = json_decode($result->bodyResponse);
        $httpResponse->httpStatusCode = $result->httpStatusCode;

        return $httpResponse;
    }

    public function GetEventLeaderboard($eventId)
    {
        $httpResponse = new HTTPResponse();
        $locationFormat = $this->Parent->baseUrl() . "event/" . $eventId . "/leaderboard";
        $url = $this->BuildUrl($locationFormat);
        $result = $this->curlWrapper->GetV2($url, $this->BuildAuthenticationValue());
        $httpResponse->bodyResponse = json_decode($result->bodyResponse);
        $httpResponse->httpStatusCode = $result->httpStatusCode;

        return $httpResponse;
    }
}

?>
