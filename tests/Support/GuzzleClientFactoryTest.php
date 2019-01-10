<?php

namespace Konsulting\JustGivingApiSdk\Tests\Support;


use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use Konsulting\JustGivingApiSdk\Support\Auth\BasicAuth;
use Konsulting\JustGivingApiSdk\Support\Auth\BearerAuth;
use Konsulting\JustGivingApiSdk\Support\GuzzleClientFactory;
use Konsulting\JustGivingApiSdk\Support\Response;
use Konsulting\JustGivingApiSdk\Tests\TestCase;
use Psr\Http\Message\ResponseInterface;

class GuzzleClientFactoryTest extends TestCase
{
    /** @test */
    public function it_builds_a_client_with_basic_auth()
    {
        $auth = new BasicAuth('my user', 'pass123');
        $factory = new GuzzleClientFactory('root domain', 'api key', 2, $auth);
        $client = $factory->createClient();

        $expected = $this->buildExpectedClient([
            'headers' => [
                'Accept'        => 'application/json',
                'Authorization' => 'Basic ' . base64_encode('my user:pass123'),
                'x-api-key'     => 'api key',
            ],
        ]);

        $this->assertEquals($expected, $client);
    }

    /** @test */
    public function it_builds_a_client_with_a_bearer_token()
    {
        $auth = new BearerAuth('my_token');
        $factory = new GuzzleClientFactory('root domain', 'api key', 2, $auth);
        $client = $factory->createClient();

        $expected = $this->buildExpectedClient([
            'headers' => [
                'Accept'        => 'application/json',
                'Authorization' => 'Bearer my_token',
                'x-api-key'     => 'api key',
            ],
        ]);

        $this->assertEquals($expected, $client);
    }

    /**
     * Build a client so we can compare within tests.
     *
     * @param array $options
     * @return Client
     */
    protected function buildExpectedClient($options)
    {
        $stack = HandlerStack::create();
        $stack->push(Middleware::mapResponse(function (ResponseInterface $response) {
            return new Response($response);
        }));

        return new Client(array_merge([
            'http_errors' => false,
            'handler'     => $stack,
            'base_uri'    => 'root domain/v2/',
            'headers'     => [
                'Accept'        => 'application/json',
                'Authorization' => 'Basic ',
                'x-api-key'     => 'api key',
            ],
        ], $options));
    }
}
