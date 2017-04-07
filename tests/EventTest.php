<?php

namespace Klever\JustGivingApiSdk\Tests;

use Klever\JustGivingApiSdk\Clients\Models\Event;

class EventTest extends Base
{
    /** @test */
    public function it_retrieves_an_event_given_an_event_id()
    {
        $response = $this->client->Event->Retrieve(479546)->getBodyAsObject();
        $this->assertEquals($response->name, 'Virgin London Marathon 2011 - Applying for a charity place');
    }

    /** @test */
    public function it_retrieves_an_event_listing()
    {
        $response = $this->client->event->retrieve(479546)->getBodyAsObject();

        $this->assertEqualAttributes(Event::class, $response);
    }

    public function it_retrieves_fundraising_pages_for_a_given_event()
    {
        $response = $this->client->Event->RetrievePages(479546)->getBodyAsObject();
        $pages = $response->fundraisingPages;

        $this->assertObjectHasAttribute('companyAppealId', $pages[0]);
        $this->assertObjectHasAttribute('createdDate', $pages[0]);
        $this->assertObjectHasAttribute('currencyCode', $pages[0]);
    }
}
