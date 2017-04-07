<?php

namespace Klever\JustGivingApiSdk\Tests;

class LeaderboardTest extends Base
{
    /** @test */
    public function it_retrieves_the_charity_leaderboard_listing_for_a_charity_id()
    {
        $response = $this->client->leaderboard->GetCharityLeaderboard(2050)->getBodyAsObject();

        $this->assertObjectHasAttribute('charityId', $response);
        $this->assertObjectHasAttribute('currency', $response);
        $this->assertObjectHasAttribute('pages', $response);
    }

    /** @test */
    public function it_retrieves_the_event_leaderboard_listing_for_an_event_id()
    {
        $response = $this->client->Leaderboard->GetEventLeaderboard(479546)->getBodyAsObject();

        $this->assertObjectHasAttribute('currency', $response);
        $this->assertObjectHasAttribute('eventName', $response);
        $this->assertObjectHasAttribute('pages', $response);
        $this->assertObjectHasAttribute('raisedAmount', $response);
    }
}
