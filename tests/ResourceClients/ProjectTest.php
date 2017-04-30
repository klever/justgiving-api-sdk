<?php

namespace Klever\JustGivingApiSdk\Tests\ResourceClients;

class ProjectTest extends ResourceClientTestCase
{
    /** @test */
    public function it_retrieves_a_project_by_its_id()
    {
        $response = $this->client->project->retrieve(2050);

        $this->assertObjectHasAttributes(['activities', 'charityId', 'country', 'description'], $response->body);
    }
}
