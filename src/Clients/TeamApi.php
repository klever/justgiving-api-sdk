<?php

namespace Klever\JustGivingApiSdk\Clients;

class TeamApi extends ClientBase
{
    public function Create($team)
    {
        $locationFormat = $this->Parent->baseUrl() . "team/" . $team->teamShortName;
        $url = $this->BuildUrl($locationFormat);
        $payload = json_encode($team);
        $json = $this->curlWrapper->Put($url, $this->BuildAuthenticationValue(), $payload);

        return json_decode($json);
    }

    public function Team($teamShortName)
    {
        $locationFormat = $this->Parent->baseUrl() . "team/" . $teamShortName;
        $url = $this->BuildUrl($locationFormat);
        $json = $this->curlWrapper->Get($url);

        return json_decode($json);
    }

    public function CheckIfExist($teamShortName)
    {
        $locationFormat = $this->Parent->baseUrl() . "team/" . $teamShortName;
        $url = $this->BuildUrl($locationFormat);
        $httpInfo = $this->curlWrapper->Head($url);
        if ($httpInfo['http_code'] == 200) {
            return true;
        } else if ($httpInfo['http_code'] == 404) {
            return false;
        }
    }

    public function JoinTeam($teamShortName, $joinTeamRequest)
    {
        $locationFormat = $this->Parent->baseUrl() . "team/join/" . $teamShortName;
        $payload = json_encode($joinTeamRequest);
        $url = $this->BuildUrl($locationFormat);
        $httpInfo = $this->curlWrapper->Put($url, $this->BuildAuthenticationValue(), $payload, true);
        if ($httpInfo['http_code'] == 200) {
            return true;
        } else if ($httpInfo['http_code'] == 404) {
            return false;
        }
    }
}
