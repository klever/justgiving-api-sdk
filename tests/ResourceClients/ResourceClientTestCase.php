<?php

namespace Konsulting\JustGivingApiSdk\Tests\ResourceClients;

use GuzzleHttp\Client;
use Konsulting\JustGivingApiSdk\JustGivingClient;
use Konsulting\JustGivingApiSdk\ResourceClients\Models\Address;
use Konsulting\JustGivingApiSdk\ResourceClients\Models\CreateAccountRequest;
use Konsulting\JustGivingApiSdk\Support\Auth\AppAuth;
use Konsulting\JustGivingApiSdk\Support\Auth\BasicAuth;
use Konsulting\JustGivingApiSdk\Support\GuzzleClientFactory;
use Konsulting\JustGivingApiSdk\Support\Response;
use Konsulting\JustGivingApiSdk\Tests\TestCase;
use Konsulting\JustGivingApiSdk\Tests\TestContext;

class ResourceClientTestCase extends TestCase
{
    /**
     * The email belonging to the (temporary) test account created on the API. Password is 'password'.
     *
     * @var string
     */
    protected static $testEmail;

    /** @var JustGivingClient */
    protected $client;

    /** @var  Client */
    protected $guzzleClient;

    /**
     * The setup variables for performing tests.
     *
     * @var TestContext
     */
    protected $context;

    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();

        $client = new JustGivingClient(
            (new GuzzleClientFactory(
                new AppAuth((new TestContext)->apiKey)
            ))->createClient()
        );

        $uniqueId = uniqid();
        static::$testEmail = "test+" . $uniqueId . "@testing.com";

        $request = new CreateAccountRequest([
            'email'     => static::$testEmail,
            'firstName' => "first" . $uniqueId,
            'lastName'  => "last" . $uniqueId,
            'password'  => 'password',
            'title'     => "Mr",

            'address'                  => new Address([
                'line1'             => "testLine1" . $uniqueId,
                'line2'             => "testLine2" . $uniqueId,
                'country'           => "United Kingdom",
                'countyOrState'     => "testCountyOrState" . $uniqueId,
                'townOrCity'        => "testTownOrCity" . $uniqueId,
                'postcodeOrZipcode' => "M130EJ",
            ]),
            'acceptTermsAndConditions' => true,
        ]);

        $response = $client->Account->create($request);

        static::assertTrue($response->wasSuccessful(),
            'Could not create test account.' . PHP_EOL . implode(PHP_EOL, $response->errors));
    }


    protected function setUp()
    {
        parent::setUp();

        $this->context = new TestContext();

        $auth = new BasicAuth($this->context->apiKey, static::$testEmail, $this->context->testValidPassword);

        $this->guzzleClient = (new GuzzleClientFactory($auth))->createClient();

        $this->client = new JustGivingClient($this->guzzleClient);
        $this->wait(1);
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
            'email'     => $email ?: "test+" . $uniqueId . "@testing.com",
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

            'acceptTermsAndConditions' => true,
        ], $options));

        return $this->client->Account->create($request);
    }

    protected function assertSuccessfulResponse(Response $response)
    {
        $this->assertTrue($response->wasSuccessful(), implode(PHP_EOL, $response->errors));
    }
}
