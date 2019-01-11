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
    /**
     * @test
     * @dataProvider clientAuthProvider
     */
    public function it_builds_a_client_with_auth($auth, $expectedAuthString)
    {
        $factory = new GuzzleClientFactory('root domain', 'api key', 2, $auth);
        $client = $factory->createClient();

        $expected = $this->buildExpectedClient([
            'headers' => [
                'Accept'        => 'application/json',
                'Authorization' => $expectedAuthString,
                'x-api-key'     => 'api key',
            ],
        ]);

        $this->assertEquals($expected, $client);
    }

    public function clientAuthProvider()
    {
        return [
            [new BasicAuth('my user', 'pass123'), 'Basic ' . base64_encode('my user:pass123')],
            [new BearerAuth('my_token'), 'Bearer my_token'],
            [null, ''],
        ];
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
