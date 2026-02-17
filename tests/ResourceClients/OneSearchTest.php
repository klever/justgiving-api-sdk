<?php

namespace Konsulting\JustGivingApiSdk\Tests\ResourceClients;

use PHPUnit\Framework\Attributes\Test;

class OneSearchTest extends ResourceClientTestCase
{
    #[Test]
    public function it_searches_the_entire_site()
    {
        $response = $this->client->oneSearch->index('charity');

        $this->assertTrue(is_array($response->body->GroupedResults));
        $this->assertTrue(is_array($response->body->GroupedResults[0]->Results));
        $this->assertObjectHasAttributes(['Title', 'Count', 'Results'], $response->body->GroupedResults[0]);
    }
}
