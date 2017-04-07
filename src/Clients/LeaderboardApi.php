<?php

namespace Klever\JustGivingApiSdk\Clients;

class LeaderboardApi extends ClientBase
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
