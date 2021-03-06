<?php

namespace Konsulting\JustGivingApiSdk\Tests\ResourceClients;

class OneSearchTest extends ResourceClientTestCase
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
