<?php

namespace Konsulting\JustGivingApiSdk\Tests\ResourceClients;

use Konsulting\JustGivingApiSdk\ResourceClients\Models\AuthenticateCharityAccountRequest;

class CharityTest extends ResourceClientTestCase
{
    /** @test */
    public function it_retrieves_a_charity_by_charity_id()
    {
        $response = $this->client->Charity->getById(2050);

        $this->assertSame('The Demo Charity', $response->name);
    }

    /** @test */
    public function it_fails_charity_authentication_when_false_credentials_supplied()
    {
        $authenticateRequest = new AuthenticateCharityAccountRequest([
            'username' => 'myUsername',
            'password' => 'badPassword',
            'pin'      => 'badPin',
        ]);

        $response = $this->client->charity->authenticate($authenticateRequest);

        $this->assertFalse($response->wasSuccessful());
        $this->assertEquals('Invalid charity details', $response->getReasonPhrase());
    }

    /** @test */
    public function it_retrieves_charity_events_by_charity_id()
    {
        $response = $this->client->Charity->getEventsByCharityId(2050);

        $this->assertObjectHasAttributes(['pageNumber', 'totalPages'], $response->pagination);
        $this->assertObjectHasAttributes([
            'name',
            'description',
            'completionDate',
            'expiryDate',
            'startDate',
            'eventType',
            'location',
        ], $response->events[0]);
    }

    /** @test */
    public function it_retrieves_charity_donations_by_charity_id()
    {
        $response = $this->client->Charity->getDonations(2050);

        $this->assertObjectHasAttributes(['amount', 'currencyCode'], $response->donations[0]);
    }

    /** @test */
    public function it_retrieves_all_charity_categories()
    {
        $response = $this->client->Charity->categories();

        $this->assertObjectHasAttributes(['category', 'id'], $response->body[0]);
    }
}
