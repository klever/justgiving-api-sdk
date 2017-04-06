<?php

namespace Klever\JustGivingApiSdk\Clients;

class TeamApi extends ClientBase
{
    public function Create($team)
    {
        $url = "team/" . $team->teamShortName;

        $payload = json_encode($team);
        $json = $this->curlWrapper->Put($url, $this->BuildAuthenticationValue(), $payload);

        return json_decode($json);
    }

    public function Team($teamShortName)
    {
        $url = "team/" . $teamShortName;

        $json = $this->curlWrapper->Get($url);

        return json_decode($json);
    }

    public function CheckIfExist($teamShortName)
    {
        $url = "team/" . $teamShortName;

        $httpInfo = $this->curlWrapper->Head($url);
        if ($httpInfo['http_code'] == 200) {
            return true;
        } else if ($httpInfo['http_code'] == 404) {
            return false;
        }
    }

    public function JoinTeam($teamShortName, $joinTeamRequest)
    {
        $url = "team/join/" . $teamShortName;
        $payload = json_encode($joinTeamRequest);

        $httpInfo = $this->curlWrapper->Put($url, $this->BuildAuthenticationValue(), $payload, true);
        if ($httpInfo['http_code'] == 200) {
            return true;
        } else if ($httpInfo['http_code'] == 404) {
            return false;
        }
    }
}
