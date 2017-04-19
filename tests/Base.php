<?php

namespace Klever\JustGivingApiSdk\Tests;

use Klever\JustGivingApiSdk\JustGivingClient;
use Klever\JustGivingApiSdk\Support\GuzzleClientFactory;
use PHPUnit\Framework\TestCase;

class Base extends TestCase
{
    /**
     * @var JustGivingClient
     */
    protected $client;

    /**
     * The setup variables for performing tests.
     *
     * @var TestContext
     */
    protected $context;

    protected function setUp()
    {
        $this->context = new TestContext();

        $guzzleClient = GuzzleClientFactory::build(
            $this->context->apiUrl,
            $this->context->apiKey,
            $this->context->apiVersion,
            $this->context->testUsername,
            $this->context->testValidPassword
        );

        $this->client = new JustGivingClient($guzzleClient);
    }

    /**
     * Tests if two objects have the same attributes.
     *
     * @param object|string $expectedObject
     * @param object        $actualObject
     */
    protected function assertEqualAttributes($expectedObject, $actualObject)
    {
        $expectedObject = is_string($expectedObject) ? new $expectedObject : $expectedObject;
        $expectedKeys = array_keys(get_object_vars($expectedObject));

        $intersect = array_intersect($expectedKeys, array_keys(get_object_vars($actualObject)));
        $this->assertEquals($expectedKeys, $intersect);
    }

    /**
     * Check if an object has all of an array of attributes.
     *
     * @param array  $attributes
     * @param object $object
     */
    protected function assertObjectHasAttributes($attributes, $object)
    {
        foreach ($attributes as $attribute) {
            $this->assertObjectHasAttribute($attribute, $object);
        }
    }
}
