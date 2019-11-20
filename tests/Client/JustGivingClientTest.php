<?php

namespace Konsulting\JustGivingApiSdk\Tests\Client;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Konsulting\JustGivingApiSdk\Exceptions\ClassNotFoundException;
use Konsulting\JustGivingApiSdk\JustGivingClient;
use Konsulting\JustGivingApiSdk\ResourceClients\AccountClient;
use Konsulting\JustGivingApiSdk\Support\Auth\AuthValue;
use Konsulting\JustGivingApiSdk\Tests\TestCase;
use Mockery;
use Mockery\MockInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;

class JustGivingClientTest extends TestCase
{
    /**
     * Get a new JustGiving client instance.
     *
     * @return JustGivingClient
     */
    private function getClient()
    {
        return new JustGivingClient($this->getAuthMock(), Mockery::mock(ClientInterface::class));
    }

    /**
     * Get a mock AuthValue object.
     *
     * @return AuthValue|MockInterface
     */
    private function getAuthMock()
    {
        $auth = Mockery::mock(AuthValue::class);
        $auth->shouldReceive('getHeaders')
            ->andReturn([
                'x-api-key'         => 'abcdef',
                'x-application-key' => 'secret',
            ]);

        return $auth;
    }

    /** @test */
    public function it_returns_an_api_client_class_from_a_property_call()
    {
        $this->assertInstanceOf(AccountClient::class, $this->getClient()->account);
        $this->assertInstanceOf(AccountClient::class, $this->getClient()->Account);
    }

    /** @test */
    public function it_throws_an_exception_if_a_non_existent_class_name_is_called()
    {
        $this->expectException(ClassNotFoundException::class);

        $this->getClient()->InvalidClass;
    }

    /** @test */
    public function it_returns_the_same_client_class_instance_if_called_twice()
    {
        $client = $this->getClient();

        $clientOne = $client->account;
        $clientTwo = $client->account;

        $this->assertSame($clientOne, $clientTwo);
    }

    /** @test */
    public function it_uses_a_default_base_url_and_api_version()
    {
        $http = Mockery::mock(ClientInterface::class);
        $http->shouldReceive('sendRequest')
            ->withArgs(function (RequestInterface $request) {
                return $request->getUri()->__toString() === 'https://api.justgiving.com/v1/account';
            })
            ->once()
            ->andReturn(new Response);

        $client = new JustGivingClient($this->getAuthMock(), $http);

        $client->Account->retrieve();
    }

    /** @test */
    public function it_uses_the_given_base_url_and_api_version()
    {
        $http = Mockery::mock(ClientInterface::class);
        $http->shouldReceive('sendRequest')
            ->withArgs(function (RequestInterface $request) {
                return $request->getUri()->__toString() === 'https://example.com/v3/account';
            })
            ->once()
            ->andReturn(new Response);

        $client = new JustGivingClient($this->getAuthMock(), $http, [
            'root_domain' => 'https://example.com',
            'api_version' => 3,
        ]);

        $client->Account->retrieve();
    }

    /**
     * We're using an overload mock, which will fail if the class has already been loaded for another test.
     *
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     * @test
     */
    public function it_automatically_instantiates_a_psr_18_client()
    {
        // Overload the Guzzle client class to make sure the JustGiving client is instantiating it internally
        $http = Mockery::mock('overload:' . Client::class);
        $http->shouldReceive('send')
            ->withArgs(function (RequestInterface $request) {
                return $request->getUri()->__toString() === 'https://api.justgiving.com/v1/account';
            })
            ->once()
            ->andReturn(new Response);

        $client = new JustGivingClient($this->getAuthMock());

        $client->Account->retrieve();
    }

    /** @test */
    public function it_allows_a_custom_request_with_new_parameters_and_restores_parameters_after()
    {
        $http = Mockery::mock(ClientInterface::class);

        $expectedHeaders = [
            'Host'              => ['example3.com'],
            'Accept'            => ['application/json'],
            'x-api-key'         => ['abcdef'],
            'x-application-key' => ['secret'],
            'x-custom-header'   => ['custom'],
            'Content-Type'      => ['application/json'],
        ];

        // Test custom request
        $http->shouldReceive('sendRequest')
            ->withArgs(function (RequestInterface $request) use ($expectedHeaders) {
                return $request->getUri()->__toString() === 'https://example3.com/v5/new-endpoint'
                    && $request->getHeaders() === $expectedHeaders
                    && $request->getMethod() === 'MY METHOD'
                    && $request->getBody()->getContents() === '{"test":"json"}';
            })
            ->once()
            ->andReturn(new Response)
            ->ordered();

        // Check everything has been restored to how it was before
        $http->shouldReceive('sendRequest')
            ->withArgs(function (RequestInterface $request) {
                return $request->getUri()->__toString() === 'https://example.com/v3/account';
            })
            ->once()
            ->andReturn(new Response)
            ->ordered();

        $client = new JustGivingClient($this->getAuthMock(), $http, [
            'root_domain' => 'https://example.com',
            'api_version' => 3,
        ]);

        $client->request('my method', 'new-endpoint', [
            'headers' => ['x-custom-header' => 'custom'],
            'json'    => ['test' => 'json'],
        ], [
            'root_domain' => 'https://example3.com',
            'api_version' => 5,
        ]);

        $client->Account->retrieve();
    }
}
