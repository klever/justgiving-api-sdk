<?php

namespace Konsulting\JustGivingApiSdk\Tests\ResourceClients;

use Konsulting\JustGivingApiSdk\ResourceClients\Models\SearchInMemoryRequest;
use Konsulting\JustGivingApiSdk\ResourceClients\Models\SearchTeamRequest;

class SearchTest extends ResourceClientTestCase
{
    /** @test */
    public function it_finds_a_charity_from_a_search_string()
    {
        $response = $this->client->Search->charity('the demo charity');

        $this->assertSuccessfulResponse($response);
        $this->assertGreaterThan(0, count($response->body->charitySearchResults), 'No search results returned.');
        $attributes = ['charityId', 'name', 'charityDisplayName', 'registrationNumber', 'description'];
        $this->assertObjectHasAttributes($attributes, $response->body->charitySearchResults[0]);

        foreach ($response->body->charitySearchResults as $charity) {
            if ($charity->charityId === '189701') {
                $this->assertSame('citizens uk', strtolower($charity->name));
            }
        }
    }

    /** @test */
    public function it_searches_for_events()
    {
        $response = $this->client->search->event('event');

        $this->assertSuccessfulResponse($response);
        $this->assertObjectHasAttributes(['next', 'numberOfHits', 'prev', 'query', 'totalPages', 'events'],
            $response->body);
        $this->assertObjectHasAttributes(
            [
                'amountGiftAid',
                'amountRaised',
                'categoryId',
                'completionDate',
                'description',
                'expiryDate',
                'id',
                'isManaged',
                'location',
                'name',
                'numberOfLivePages',
                'startDate',
            ],
            $response->body->events[0]
        );
    }

    /** @test */
    public function it_searches_for_fundraisers()
    {
        $response = $this->client->search->fundraiser('fundraiser', 2050);

        $this->assertSuccessfulResponse($response);
        $this->assertObjectHasAttributes([
            'PageUrl',
            'Photo',
            'ImageAbsoluteUrl',
            'PageName',
            'PageOwner',
            'TeamMembers',
            'EventName',
        ], $response->body->SearchResults[0]);
    }

    /** @test */
    public function it_searches_for_a_remembered_person()
    {
        $searchRequest = new SearchInMemoryRequest([
            'firstName' => 'Bob',
            'lastName'  => 'Smith',
        ]);

        $response = $this->client->search->inMemory($searchRequest);

        $this->assertSuccessfulResponse($response);
        $this->assertObjectHasAttributes(['next', 'numberOfHits', 'prev', 'query', 'totalPages', 'results'],
            $response->body);
        $this->assertObjectHasAttributes([
            'createdBy',
            'dateOfBirth',
            'dateOfDeath',
            'firstName',
            'gender',
            'id',
            'lastName',
            'town',
        ], $response->body->results[0]);
    }

    /** @test */
    public function it_searches_for_a_team()
    {
        $searchRequest = new SearchTeamRequest([
            'teamShortName' => 'team',
        ]);

        $response = $this->client->search->team($searchRequest);

        $this->assertSuccessfulResponse($response);
        $this->assertObjectHasAttributes(['next', 'numberOfHits', 'prev', 'query', 'totalPages', 'results'],
            $response->body);
        $this->assertObjectHasAttributes([
            'id',
            'name',
            'story',
            'targetType',
            'teamMembers',
            'teamShortName',
            'teamTarget',
            'teamType',
        ], $response->body->results[0]);
    }
}
