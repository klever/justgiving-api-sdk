<?php

namespace Konsulting\JustGivingApiSdk\ResourceClients;

use Konsulting\JustGivingApiSdk\ResourceClients\Models\JoinTeamRequest;
use Konsulting\JustGivingApiSdk\ResourceClients\Models\Team;

class TeamClient extends BaseClient
{
    protected $aliases = [
        'getByShortName' => 'GetTeam',
        'checkIfExists'  => 'CheckIfTeamExists',
        'create'         => 'CreateTeam',
        'update'         => 'UpdateTeam',
        'join'           => 'JoinTeam',
    ];

    public function getByShortName($teamShortName)
    {
        return $this->get("team/" . $teamShortName);
    }

    public function checkIfExists($teamShortName)
    {
        return $this->head("team/" . $teamShortName);
    }

    public function create(Team $team)
    {
        return $this->put("team/" . $team->teamShortName, $team);
    }

    public function update($teamShortName, Team $updatedTeam)
    {
        return $this->post('team/' . $teamShortName, $updatedTeam);
    }

    public function join($teamShortName, JoinTeamRequest $joinTeamRequest)
    {
        return $this->put("team/join/" . $teamShortName, $joinTeamRequest);
    }
}
