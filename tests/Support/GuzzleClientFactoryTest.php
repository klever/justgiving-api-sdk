<?php

namespace Klever\JustGivingApiSdk\Tests\Support;

use Klever\JustGivingApiSdk\Support\GuzzleClientFactory;
use Klever\JustGivingApiSdk\Tests\TestCase;

class GuzzleClientFactoryTest extends TestCase
{
    /** @test */
    public function it_returns_an_empty_string_if_no_credentials_are_supplied_to_build_authentication_value()
    {
        $factory = new TestFactory('root domain', 'api key', 1);
        $authenticationString = $factory->buildAuthenticationValue();

        $this->assertEquals('', $authenticationString);
    }
}

class TestFactory extends GuzzleClientFactory
{
    public function buildAuthenticationValue()
    {
        return parent::buildAuthenticationValue();
    }
}
