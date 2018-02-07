<?php

namespace Konsulting\JustGivingApiSdk\ResourceClients;

class LeaderboardClient extends BaseClient
{
    protected $aliases = [
        'getCharityLeaderboard' => 'GetCharityLeaderboard',
        'getEventLeaderboard'   => 'GetEventLeaderboard',
    ];

    public function getCharityLeaderboard($charityId)
    {
        return $this->get("charity/" . $charityId . "/leaderboard");
    }

    public function getEventLeaderboard($eventId)
    {
        return $this->get("event/" . $eventId . "/leaderboard");
    }
}
