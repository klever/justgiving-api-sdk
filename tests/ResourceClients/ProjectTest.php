<?php

namespace Konsulting\JustGivingApiSdk\Tests\ResourceClients;

use PHPUnit\Framework\Attributes\Test;

class ProjectTest extends ResourceClientTestCase
{
    #[Test]
    public function it_retrieves_a_project_by_its_id()
    {
        $response = $this->client->project->retrieve(2050);

        $this->assertObjectHasAttributes(['activities', 'charityId', 'country', 'description'], $response->body);
    }
}
