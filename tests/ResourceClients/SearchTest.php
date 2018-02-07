<?php

namespace Konsulting\JustGivingApiSdk\Tests\ResourceClients;

use Konsulting\JustGivingApiSdk\ResourceClients\Models\SearchInMemoryRequest;
use Konsulting\JustGivingApiSdk\ResourceClients\Models\SearchTeamRequest;

class SearchTest extends ResourceClientTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->wait(5);
    }

    /** @test */
    public function it_finds_a_charity_from_a_search_string()
    {
        $response = $this->client->Search->charity('the demo charity1');

        foreach ($response->body->charitySearchResults as $charity) {
            if ($charity->charityId == 2050) {
                $this->assertEquals('the demo charity1', strtolower($charity->name));
            }
        }
    }

    /** @test */
    public function it_searches_for_events()
    {
        $response = $this->client->search->event('event');

        $this->assertTrue($response->wasSuccessful());
        $this->assertObjectHasAttributes(['next', 'numberOfHits', 'prev', 'query', 'totalPages', 'events'], $response->body);
        $this->assertObjectHasAttributes(
            ['amountGiftAid', 'amountRaised', 'categoryId', 'completionDate', 'description', 'expiryDate', 'id', 'isManaged', 'location', 'name', 'numberOfLivePages', 'startDate'],
            $response->body->events[0]
        );
    }

    /** @test */
    public function it_searches_for_fundraisers()
    {
        $response = $this->client->search->fundraiser('fundraiser', 2050);

        $this->assertTrue($response->wasSuccessful());
        $this->assertObjectHasAttributes(['PageUrl', 'Photo', 'ImageAbsoluteUrl', 'PageName', 'PageOwner', 'TeamMembers', 'EventName'], $response->body->SearchResults[0]);
    }

    /** @test */
    public function it_searches_for_a_remembered_person()
    {
        $searchRequest = new SearchInMemoryRequest([
            'firstName' => 'Bob',
            'lastName'  => 'Smith',
        ]);

        $response = $this->client->search->inMemory($searchRequest);

        $this->assertTrue($response->wasSuccessful());
        $this->assertObjectHasAttributes(['next', 'numberOfHits', 'prev', 'query', 'totalPages', 'results'], $response->body);
        $this->assertObjectHasAttributes(['createdBy', 'dateOfBirth', 'dateOfDeath', 'firstName', 'gender', 'id', 'lastName', 'town'], $response->body->results[0]);
    }

    /** @test */
    public function it_searches_for_a_team()
    {
        $searchRequest = new SearchTeamRequest([
            'teamShortName' => 'team'
        ]);

        $response = $this->client->search->team($searchRequest);

        $this->assertObjectHasAttributes(['next', 'numberOfHits', 'prev', 'query', 'totalPages', 'results'], $response->body);
        $this->assertObjectHasAttributes(['id', 'name', 'story', 'targetType', 'teamMembers', 'teamShortName', 'teamTarget', 'teamType'], $response->body->results[0]);
        $this->assertTrue($response->wasSuccessful());
    }
}
