<?php

namespace Klever\JustGivingApiSdk\Tests;

class SearchTest extends Base
{
    // TODO: test all search methods

    /** @test */
    public function it_finds_a_charity_from_a_search_string()
    {
        $response = $this->client->Search->charity('the demo charity1');

        foreach ($response->charitySearchResults as $charity) {
            if ($charity->charityId == 2050) {
                $this->assertEquals('the demo charity1', strtolower($charity->name));
            }
        }
    }
}
