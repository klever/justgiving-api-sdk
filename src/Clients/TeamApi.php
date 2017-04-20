<?php

namespace Klever\JustGivingApiSdk\Clients;

class TeamApi extends BaseClient
{
    protected $aliases = [
        'retrieve'      => ['GetTeam', 'getTeam'],
        'checkIfExists' => 'CheckIfTeamExists',
        'create'        => 'CreateTeam',
        'UpdateTeam',
        'JoinTeam',
    ];

    public function retrieve($teamShortName)
    {
        return $this->get("team/" . $teamShortName);
    }

    public function checkIfExists($teamShortName)
    {
        $url = "team/" . $teamShortName;

        $httpInfo = $this->httpClient->Head($url);
        if ($httpInfo['http_code'] == 200) {
            return true;
        } else if ($httpInfo['http_code'] == 404) {
            return false;
        }
    }

    public function create($team)
    {
        $url = "team/" . $team->teamShortName;

        $payload = json_encode($team);
        $json = $this->httpClient->Put($url, $payload);

        return $json;
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
