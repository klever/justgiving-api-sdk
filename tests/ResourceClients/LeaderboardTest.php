<?php

namespace Konsulting\JustGivingApiSdk\Tests\ResourceClients;

use PHPUnit\Framework\Attributes\Test;

class LeaderboardTest extends ResourceClientTestCase
{
    #[Test]
    public function it_retrieves_the_charity_leaderboard_listing_for_a_charity_id()
    {
        $response = $this->client->leaderboard->getCharityLeaderboard(2050);

        $this->assertObjectHasAttributes(['charityId', 'currency', 'pages'], $response->body);
    }

    #[Test]
    public function it_retrieves_the_event_leaderboard_listing_for_an_event_id()
    {
        $response = $this->client->leaderboard->getEventLeaderboard(479546);

        $this->assertEquals('GBP', $response->body->currency);
        $this->assertEquals([], $response->body->pages);
        $this->assertEquals(49006.22, $response->body->raisedAmount);
    }
}
