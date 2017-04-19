<?php

namespace Klever\JustGivingApiSdk\Tests;

use Klever\JustGivingApiSdk\Clients\Models\Event;

class CharityTest extends Base
{
    /** @test */
    public function it_retrieves_a_charity_by_charity_id()
    {
        $response = $this->client->Charity->Retrieve(2050);

        $this->assertEquals('The Demo Charity1', $response->name);
    }

    /** @test */
    public function it_retrieves_charity_events_by_charity_id()
    {
        $response = $this->client->Charity->GetEventsByCharityId(2050);

        $this->assertObjectHasAttributes(['pageNumber', 'totalPages'], $response->pagination);
        $this->assertEqualAttributes(Event::class, $response->events[0]);
    }

    /** @test */
    public function it_retrieves_charity_donations_by_charity_id()
    {
        $response = $this->client->Charity->GetDonations(2050);

        $this->assertObjectHasAttributes(['amount', 'currencyCode'], $response->donations[0]);
    }

    /** @test */
    public function it_retrieves_all_charity_categories()
    {
        $response = $this->client->Charity->Categories();

        $this->assertObjectHasAttributes(['category', 'id'], $response->body[0]);
    }
}
