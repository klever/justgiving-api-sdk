<?php

namespace Klever\JustGivingApiSdk\Tests;

use Klever\JustGivingApiSdk\Clients\Models\RegisterPageRequest;
use Klever\JustGivingApiSdk\Clients\Models\Team;
use Klever\JustGivingApiSdk\Clients\Models\TeamMember;

class TeamTest extends Base
{
    protected $pageShortName;
    protected $team;

    /** @test */
    public function it_creates_a_team()
    {
        $response = $this->createTeam();

        $this->assertTrue($response->body->id > 0);
    }

    public function it_checks_if_a_team_exists()
    {
        $teamShortName = 'team' . uniqid();
        $this->createTeam($teamShortName);
        $response = $this->client->team->checkIfExists($teamShortName);

        $this->assertTrue($response->existenceCheck());
    }

    protected function createTeam($teamShortName = null)
    {
        $pageShortName = "api-test-" . uniqid();
        $this->client->fundraising->register(new RegisterPageRequest([
            'reference'       => "12345",
            'pageShortName'   => $pageShortName,
            'activityType'    => "OtherCelebration",
            'pageTitle'       => "api test",
            'pageStory'       => "This is my custom page story, which will override the default.",
            'eventName'       => "The Other Occasion of ApTest and APITest",
            'charityId'       => 2050,
            'targetAmount'    => 20,
            'eventDate'       => "/Date(1235764800000)/",
            'justGivingOptIn' => true,
            'charityOptIn'    => true,
            'charityFunded'   => false,
        ]));

        $team = new Team([
            'teamShortName' => $teamShortName ?? 'myTeam' . uniqid(),
            'name'          => 'My Team',
            'story'         => 'This is my team.',
            'targetType'    => 'Fixed',
            'teamType'      => 'Open',
            'teamTarget'    => 10000,
            'teamMembers'   => [new TeamMember(['pageShortName' => $pageShortName])],
        ]);

        return $this->client->team->create($team);
    }
}
