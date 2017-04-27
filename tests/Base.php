<?php

namespace Klever\JustGivingApiSdk\Tests;

use Klever\JustGivingApiSdk\JustGivingClient;
use Klever\JustGivingApiSdk\ResourceClients\Models\Address;
use Klever\JustGivingApiSdk\ResourceClients\Models\CreateAccountRequest;
use Klever\JustGivingApiSdk\Support\GuzzleClientFactory;
use Klever\JustGivingApiSdk\Support\Response;
use PHPUnit\Framework\TestCase;

class Base extends TestCase
{
    /**
     * @var JustGivingClient
     */
    protected $client;

    protected $guzzleClient;
    protected static $staticGuzzleClient;
    protected static $staticClient;

    /**
     * The setup variables for performing tests.
     *
     * @var TestContext
     */
    protected $context;

    protected function setUp()
    {
        ini_set('xdebug.max_nesting_level', 2048);

        $this->context = new TestContext();

        static::$staticGuzzleClient = static::$staticGuzzleClient
            ?? GuzzleClientFactory::build(
                $this->context->apiUrl,
                $this->context->apiKey,
                $this->context->apiVersion,
                $this->context->testUsername,
                $this->context->testValidPassword
            );

        static::$staticClient = static::$staticClient ?? new JustGivingClient(static::$staticGuzzleClient);

        $this->guzzleClient = static::$staticGuzzleClient;
        $this->client = static::$staticClient;
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

    /**
     * Creates an account and returns the email address.
     *
     * @param string $email
     * @param array  $options
     * @return Response
     */
    protected function createAccount($email = null, $options = [])
    {
        $uniqueId = uniqid();
        $request = new CreateAccountRequest(array_merge([
            'email'     => $email ?? "test+" . $uniqueId . "@testing.com",
            'firstName' => "first" . $uniqueId,
            'lastName'  => "last" . $uniqueId,
            'password'  => $this->context->testValidPassword,
            'title'     => "Mr",

            'address' => new Address([
                'line1'             => "testLine1" . $uniqueId,
                'line2'             => "testLine2" . $uniqueId,
                'country'           => "United Kingdom",
                'countyOrState'     => "testCountyOrState" . $uniqueId,
                'townOrCity'        => "testTownOrCity" . $uniqueId,
                'postcodeOrZipcode' => "M130EJ",
            ]),

            'acceptTermsAndConditions' => true
        ], $options));

        return $this->client->Account->create($request);
    }
}
