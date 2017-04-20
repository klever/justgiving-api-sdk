<?php

namespace Klever\JustGivingApiSdk\Clients;

class TeamApi extends BaseClient
{
    public function Create($team)
    {
        $url = "team/" . $team->teamShortName;

        $payload = json_encode($team);
        $json = $this->httpClient->Put($url, $payload);

        return json_decode($json);
    }

    public function Team($teamShortName)
    {
        $url = "team/" . $teamShortName;

        $json = $this->getContent($url);

        return json_decode($json);
    }

    public function CheckIfExist($teamShortName)
    {
        $url = "team/" . $teamShortName;

        $httpInfo = $this->httpClient->Head($url);
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

        $httpInfo = $this->httpClient->Put($url, $payload, true);
        if ($httpInfo['http_code'] == 200) {
            return true;
        } else if ($httpInfo['http_code'] == 404) {
            return false;
        }
    }
}
