<?php

namespace Klever\JustGivingApiSdk\Tests;

class ProjectTest extends Base
{
    /** @test */
    public function it_retrieves_a_project_by_its_id()
    {
        $response = $this->client->project->retrieve(2050);

        $this->assertObjectHasAttributes(['activities', 'charityId', 'country', 'description'], $response->body);
    }
}
