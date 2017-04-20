<?php

namespace Klever\JustGivingApiSdk\Clients;

class LeaderboardApi extends BaseClient
{
    public function GetCharityLeaderboard($charityId)
    {
        return $this->get("charity/" . $charityId . "/leaderboard");
    }

    public function GetEventLeaderboard($eventId)
    {
        return $this->get("event/" . $eventId . "/leaderboard");
    }
}
