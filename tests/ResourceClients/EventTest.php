<?php

namespace Konsulting\JustGivingApiSdk\Tests\ResourceClients;

use Konsulting\JustGivingApiSdk\ResourceClients\Models\EventRequest;

class EventTest extends ResourceClientTestCase
{
    /** @test */
    public function it_registers_an_event()
    {
        $eventRequest = new EventRequest([
            'name'           => 'My Event',
            'description'    => 'A description',
            "completionDate" => "/Date(1524814487875+0000)/",
            "expiryDate"     => "/Date(1524814487875+0000)/",
            "startDate"      => "/Date(1493451287875+0000)/",
            "eventType"      => "OtherCelebration",
            "location"       => "Some location",
        ]);

        $response = $this->client->event->create($eventRequest);

        $this->assertTrue($response->wasSuccessful());
    }

    /** @test */
    public function it_retrieves_an_event_given_an_event_id()
    {
        $response = $this->client->event->getById(479546);

        $this->assertEquals('Virgin London Marathon 2011 - Applying for a charity place', $response->body->name);
    }

    /** @test */
    public function it_retrieves_an_event_listing()
    {
        $response = $this->client->event->getById(479546);

        $this->assertObjectHasAttributes(['name', 'description', 'completionDate', 'expiryDate', 'startDate', 'eventType', 'location',], $response->body);
    }

    /** @test */
    public function it_retrieves_fundraising_pages_for_a_given_event()
    {
        $response = $this->client->event->getPages(479546);

        $this->assertObjectHasAttributes(['companyAppealId', 'createdDate', 'currencyCode'], $response->body->fundraisingPages[0]);
    }

    /** @test */
    public function it_retrieves_a_list_of_types_of_events()
    {
        $response = $this->client->event->getTypes();

        $this->assertTrue(is_array($response->body->eventTypes));
        $this->assertObjectHasAttributes(['description', 'eventType', 'id', 'name'], $response->body->eventTypes[0]);
    }
}
