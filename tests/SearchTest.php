<?php

namespace Klever\JustGivingApiSdk\Tests;

class SearchTest extends Base
{
    /** @test */
    public function charity_search_keyword_with_known_results_search_results_present()
    {
        $response = $this->client->Search->CharitySearch('the demo charity1');

        foreach ($response->charitySearchResults as $charity) {
            if ($charity->charityId == 2050) {
                $this->assertEquals('the demo charity1', strtolower($charity->name));
            }
        }
    }
}
