<?php

namespace Konsulting\JustGivingApiSdk\Tests\ResourceClients;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Konsulting\JustGivingApiSdk\Exceptions\ClassNotFoundException;
use Konsulting\JustGivingApiSdk\JustGivingClient;
use Konsulting\JustGivingApiSdk\ResourceClients\AccountClient;
use Konsulting\JustGivingApiSdk\Support\Auth\AuthValue;
use Konsulting\JustGivingApiSdk\Tests\TestCase;
use Mockery;
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
     * Get a mock AuthValue object.
     *
     * @return AuthValue|\Mockery\MockInterface
     */
    private function getAuthMock()
    {
        $auth = Mockery::mock(AuthValue::class);
        $auth->shouldReceive('getHeaders')
            ->andReturn([]);

        return $auth;
    }

    /**
     * @runInSeparateProcess as we're using an overload mock, which interferes with the autoloading process
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
}
