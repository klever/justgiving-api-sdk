<?php

namespace Klever\JustGivingApiSdk\Tests\ResourceClients;

use GuzzleHttp\Client;
use Klever\JustGivingApiSdk\JustGivingClient;
use Klever\JustGivingApiSdk\ResourceClients\Models\Address;
use Klever\JustGivingApiSdk\ResourceClients\Models\CreateAccountRequest;
use Klever\JustGivingApiSdk\Support\GuzzleClientFactory;
use Klever\JustGivingApiSdk\Support\Response;
use Klever\JustGivingApiSdk\Tests\TestCase;
use Klever\JustGivingApiSdk\Tests\TestContext;

class ResourceClientTestCase extends TestCase
{
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

    protected function setUp()
    {
        parent::setUp();

        $this->context = new TestContext();

        $this->guzzleClient = GuzzleClientFactory::build(
            $this->context->apiUrl,
            $this->context->apiKey,
            $this->context->apiVersion,
            $this->context->testUsername,
            $this->context->testValidPassword
        );

        $this->client = new JustGivingClient($this->guzzleClient);
        sleep(3);
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
