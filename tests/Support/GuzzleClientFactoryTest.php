<?php

namespace Konsulting\JustGivingApiSdk\Tests\Support;


use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use Illuminate\Support\Arr;
use Konsulting\JustGivingApiSdk\Support\Auth\AppAuth;
use Konsulting\JustGivingApiSdk\Support\Auth\BasicAuth;
use Konsulting\JustGivingApiSdk\Support\Auth\BearerAuth;
use Konsulting\JustGivingApiSdk\Support\GuzzleClientFactory;
use Konsulting\JustGivingApiSdk\Support\Response;
use Konsulting\JustGivingApiSdk\Tests\TestCase;
use Psr\Http\Message\ResponseInterface;

class GuzzleClientFactoryTest extends TestCase
{
    /** @test */
    public function it_can_have_a_custom_root_domain_and_api_version()
    {
        $factory = new GuzzleClientFactory(new AppAuth('my_key'), [
            'root_domain' => 'https://example.com',
            'api_version' => 2,
        ]);
        $client = $factory->createClient();

        $expected = $this->buildExpectedClient([
            'base_uri' => 'https://example.com/v2/',
            'headers'  => ['x-api-key' => 'my_key'],
        ]);

        $this->assertEquals($expected, $client);
    }

    /**
     * @test
     * @dataProvider clientAuthProvider
     */
    public function it_builds_a_client_with_auth($auth, $expectedHeaders)
    {
        $factory = new GuzzleClientFactory($auth);
        $client = $factory->createClient();

        $expected = $this->buildExpectedClient(['headers' => $expectedHeaders]);

        $this->assertEquals($expected, $client);
    }

    public function clientAuthProvider()
    {
        return [
            [
                new BasicAuth('my_key', 'my user', 'pass123'),
                [
                    'Authorization' => 'Basic ' . base64_encode('my user:pass123'),
                    'x-api-key'     => 'my_key',
                ],
            ],
            [
                new BearerAuth('my_key', 'oauth_secret', 'my_token'),
                [
                    'Authorization'     => 'Bearer my_token',
                    'x-api-key'         => 'my_key',
                    'x-application-key' => 'oauth_secret',
                ],
            ],
            [new AppAuth('my_key'), ['x-api-key' => 'my_key']],
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

        $headers = array_merge(['Accept' => 'application/json'],
            Arr::pull($options, 'headers', []));

        return new Client(array_merge([
            'http_errors' => false,
            'handler'     => $stack,
            'base_uri'    => 'https://api.justgiving.com/v1/',
            'headers'     => $headers,
        ], $options));
    }
}
