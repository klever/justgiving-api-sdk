<?php

namespace Klever\JustGivingApiSdk\Tests\ResourceClients;

use Klever\JustGivingApiSdk\Tests\Base;

class OneSearchTest extends Base
{
    /** @test */
    public function it_searches_the_entire_site()
    {
        $response = $this->client->oneSearch->index('charity');

        $this->assertTrue(is_array($response->body->GroupedResults));
        $this->assertTrue(is_array($response->body->GroupedResults[0]->Results));
        $this->assertObjectHasAttributes(['Title', 'Count', 'Results'], $response->body->GroupedResults[0]);
    }
}
