<?php

namespace Klever\JustGivingApiSdk\Tests;

use Klever\JustGivingApiSdk\JustGivingClient;

class Base extends \PHPUnit\Framework\TestCase
{
    protected $client;
    protected $context;

    protected function setUp()
    {
        $testContext = new TestContext();
        $this->context = $testContext;
        $this->client = new JustGivingClient($testContext->ApiLocation, $testContext->ApiKey, $testContext->ApiVersion, $testContext->TestUsername, $testContext->TestValidPassword);
        $this->client->debug = $testContext->Debug;
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


class TestContext
{
    public $ApiLocation;
    public $ApiKey;
    public $TestUsername;
    public $TestValidPassword;
    public $TestInvalidPassword;
    public $ApiVersion;
    public $Debug;

    public function __construct()
    {
        $this->ApiLocation = "https://api.sandbox.justgiving.com/";
        $this->ApiKey = "decbf1d2";
        $this->TestUsername = "apiunittest@justgiving.com";
        $this->TestValidPassword = "password";
        $this->TestInvalidPassword = "badPassword";
        $this->ApiVersion = 1;
        $this->Debug = true;
    }
}
