<?php

namespace Konsulting\JustGivingApiSdk\Tests\Models;

use Konsulting\JustGivingApiSdk\Exceptions\InvalidPropertyException;
use Konsulting\JustGivingApiSdk\ResourceClients\Models\Team;
use Konsulting\JustGivingApiSdk\Tests\TestCase;

class ModelTest extends TestCase
{
    /**
     * @var Team
     */
    protected $team;

    /**
     * @var array
     */
    protected $teamData;

    protected function setUp(): void
    {
        $this->teamData = [
            'teamShortName' => 'tst',
            'name'          => 'team name',
            'story'         => 'story',
            'targetType'    => 'target type',
            'teamType'      => 'team type',
            'teamTarget'    => 'target',
            'teamMembers'   => ['one', 'two'],
        ];
        $this->team = (new Team)->fill($this->teamData);
    }

    /** @test */
    public function it_returns_a_list_of_attributes_and_values_on_the_model()
    {
        $this->assertEquals($this->teamData, $this->team->getAttributes());
    }

    /** @test */
    public function it_returns_a_list_of_attribute_names_on_the_model()
    {
        $this->assertEquals(array_keys($this->teamData), $this->team->getAttributeNames());
    }

    /** @test */
    public function it_throws_an_exception_if_a_property_is_filled_that_does_not_exist()
    {
        $this->expectException(InvalidPropertyException::class);

        (new Team)->fill(['Target' => 1]);
    }
}
