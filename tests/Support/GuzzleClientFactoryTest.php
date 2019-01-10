<?php

namespace Konsulting\JustGivingApiSdk\Tests\Support;


use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use Konsulting\JustGivingApiSdk\Support\Auth\BasicAuth;
use Konsulting\JustGivingApiSdk\Support\GuzzleClientFactory;
use Konsulting\JustGivingApiSdk\Support\Response;
use Konsulting\JustGivingApiSdk\Tests\TestCase;
use Psr\Http\Message\ResponseInterface;

class GuzzleClientFactoryTest extends TestCase
{
    /** @test */
    public function it_returns_an_empty_string_if_no_credentials_are_supplied_to_build_authentication_value()
    {
        $factory = new TestFactory('root domain', 'api key', 1);
        $authenticationString = $factory->buildAuthenticationValue();

        $this->assertEquals('', $authenticationString);
    }

    /** @test */
    public function it_builds_a_client_with_basic_auth()
    {
        $auth = new BasicAuth('my user', 'pass123');
        $factory = new GuzzleClientFactory('root domain', 'api key', 2, $auth);

        $client = $factory->createClient();

        $stack = HandlerStack::create();
        $stack->push(Middleware::mapResponse(function (ResponseInterface $response) {
            return new Response($response);
        }));

        $expected = new Client([
            'http_errors' => false,
            'handler'     => $stack,
            'base_uri'    => 'root domain/v2/',
            'headers'     => [
                'Accept'        => 'application/json',
                'Authorization' => 'Basic ' . base64_encode('my user:pass123'),
                'x-api-key'     => 'api key',
            ],
        ]);

        $this->assertEquals($expected, $client);
    }
}

class TestFactory extends GuzzleClientFactory
{
    public function buildAuthenticationValue()
    {
        return parent::buildAuthenticationValue();
    }
}
