<?php

namespace Klever\JustGivingApiSdk\Tests\ResourceClients;

class LeaderboardTest extends ResourceClientTestCase
{
    /** @test */
    public function it_retrieves_the_charity_leaderboard_listing_for_a_charity_id()
    {
        $response = $this->client->leaderboard->getCharityLeaderboard(2050);

        $this->assertObjectHasAttributes(['charityId', 'currency', 'pages'], $response->body);
    }

    /** @test */
    public function it_retrieves_the_event_leaderboard_listing_for_an_event_id()
    {
        $response = $this->client->leaderboard->getEventLeaderboard(479546);

        $this->assertEquals('GBP', $response->body->currency);
        $this->assertEquals([], $response->body->pages);
        $this->assertEquals(0, $response->body->raisedAmount);
    }
}
