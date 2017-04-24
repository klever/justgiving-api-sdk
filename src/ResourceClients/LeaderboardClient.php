<?php

namespace Klever\JustGivingApiSdk\ResourceClients;

class LeaderboardClient extends BaseClient
{
    protected $aliases = [
        'getCharityLeaderboard' => 'GetCharityLeaderboard',
        'getEventLeaderboard'   => 'GetEventLeaderboard',
    ];

    public function GetCharityLeaderboard($charityId)
    {
        return $this->get("charity/" . $charityId . "/leaderboard");
    }

    public function GetEventLeaderboard($eventId)
    {
        return $this->get("event/" . $eventId . "/leaderboard");
    }
}
