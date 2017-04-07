<?php

namespace Klever\JustGivingApiSdk\Tests\Models;

use Klever\JustGivingApiSdk\Clients\Models\CreateAccountRequest;
use Klever\JustGivingApiSdk\Clients\Models\Team;
use Klever\JustGivingApiSdk\Tests\Base;

class ModelTest extends Base
{
    /**
     * @var Team
     */
    protected $team;

    /**
     * @var array
     */
    protected $teamData;

    protected function setUp()
    {
        $this->teamData = [
            'teamShortName' => 'tst',
            'name'          => 'team name',
            'story'         => 'story',
            'targetType'    => 'target type',
            'teamType'      => 'team type',
            'target'        => 'target',
            'teamMembers'   => ['one', 'two']
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
    public function it_flattens_nested_object_attributes()
    {
        $objectFields = ['reference', 'title', 'firstName', 'lastName', 'email', 'password', 'acceptTermsAndConditions'];
        $addressData = [
            'line1'             => 'test line1',
            'line2'             => 'test line2',
            'townOrCity'        => 'test townOrCity',
            'countyOrState'     => 'test countyOrState',
            'country'           => 'test country',
            'postcodeOrZipcode' => 'test postcodeOrZipcode',
        ];
        $createAccount = new CreateAccountRequest;
        $createAccount->address->fill($addressData);
        $prependAddress = function ($key) {
            return 'Address.' . $key;
        };

        $expected = array_merge(
            $objectFields,
            array_map($prependAddress, array_keys($addressData))
        );

        $this->assertEquals($expected, $createAccount->getAttributeNames());
    }
}
